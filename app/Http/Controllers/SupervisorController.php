<?php

namespace App\Http\Controllers;

use App\Models\Department;
use App\Models\Report;
use App\Models\Task;
use App\Models\User;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Illuminate\Support\Facades\Auth;

class SupervisorController extends Controller
{
    public function dashboard()
    {
        $user = Auth::user();
        if ($user->type !== 'supervisor') {
            abort(403);
        }

        $deptId = $user->department_id;

        $stats = [
            'internsCount' => User::where('department_id', $deptId)
                ->where('type', 'intern')
                ->count(),
            'pendingReportsCount' => Report::whereHas('user', function ($q) use ($deptId) {
                    $q->where('department_id', $deptId)->where('type', 'intern');
                })
                ->where('status', 'pending')
                ->count(),
            'pendingTasksCount' => Task::whereHas('user', function ($q) use ($deptId) {
                    $q->where('department_id', $deptId)->where('type', 'intern');
                })
                ->where('status', '!=', 'completed')
                ->where('due_date', '>=', now())
                ->count(),
            'totalReportsCount' => Report::whereHas('user', function ($q) use ($deptId) {
                    $q->where('department_id', $deptId)->where('type', 'intern');
                })
                ->count(),
        ];

        return Inertia::render('Supervisor/Dashboard', [
            'stats' => $stats,
        ]);
    }

    public function submissions()
    {
        $user = Auth::user();
        if ($user->type !== 'supervisor') {
            abort(403);
        }

        $deptId = $user->department_id;

        $pendingReports = Report::whereHas('user', function ($q) use ($deptId) {
                $q->where('department_id', $deptId)->where('type', 'intern');
            })
            ->where('status', 'pending')
            ->with('user')
            ->orderBy('created_at', 'desc')
            ->paginate(10)
            ->withQueryString();

        $pendingTasks = Task::whereHas('user', function ($q) use ($deptId) {
                $q->where('department_id', $deptId)->where('type', 'intern');
            })
            ->where('status', '!=', 'completed')
            ->where('due_date', '>=', now())
            ->with('user')
            ->orderBy('due_date')
            ->paginate(10)
            ->withQueryString();

        return Inertia::render('Supervisor/Submissions/index', [
            'pendingReports' => $pendingReports,
            'pendingTasks' => $pendingTasks,
        ]);
    }

    public function showSubmission(Report $report)
    {
        $user = Auth::user();
        if ($user->type !== 'supervisor') {
            abort(403);
        }

        $deptId = $user->department_id;

        if ($report->user->department_id !== $deptId || $report->user->type !== 'intern') {
            abort(403);
        }

        $report->load('user');

        return Inertia::render('Supervisor/Submissions/show', [
            'report' => $report,
        ]);
    }

    public function reports()
    {
        $user = Auth::user();
        if ($user->type !== 'supervisor') {
            abort(403);
        }

        if (is_null($user->department_id)) {
            return Inertia::render('Supervisor/Reports/index', [
                'reports' => collect([])->paginate(15),
                'query' => [],
                'flash' => ['warning' => 'No department assigned. Contact admin.'],
            ]);
        }

        $deptId = $user->department_id;
        $query = array_filter(request()->query(), fn($value) => !is_null($value) && $value !== '');

        $reports = Report::whereHas('user', function ($q) use ($deptId) {
                $q->where('department_id', $deptId)->where('type', 'intern');
            })
            ->with('user')
            ->orderBy('created_at', 'desc')
            ->paginate(15)
            ->appends($query);

        return Inertia::render('Supervisor/Reports/index', [
            'reports' => $reports,
            'query' => $query,
        ]);
    }

    public function interns()
    {
        $user = Auth::user();
        if ($user->type !== 'supervisor') {
            abort(403);
        }

        if (is_null($user->department_id)) {
            return Inertia::render('Supervisor/Interns/index', [
                'interns' => collect([])->paginate(20),
                'query' => [],
                'flash' => ['warning' => 'No department assigned. Contact admin.'],
            ]);
        }

        $deptId = $user->department_id;
        $query = array_filter(request()->query(), fn($value) => !is_null($value) && $value !== '');

        $interns = User::where('department_id', $deptId)
            ->where('type', 'intern')
            ->withCount(['reports', 'tasks'])
            ->orderBy('name')
            ->paginate(20)
            ->appends($query);

        return Inertia::render('Supervisor/Interns/index', [
            'interns' => $interns,
            'query' => $query,
        ]);
    }

    public function tasks()
    {
        $user = Auth::user();
        if ($user->type !== 'supervisor') {
            abort(403);
        }

        if (is_null($user->department_id)) {
            return Inertia::render('Supervisor/Tasks/index', [
                'tasks' => collect([])->paginate(15),
                'query' => [],
                'flash' => ['warning' => 'No department assigned. Contact admin.'],
            ]);
        }

        $deptId = $user->department_id;
        $query = array_filter(request()->query(), fn($value) => !is_null($value) && $value !== '');

        $tasks = Task::whereHas('user', function ($q) use ($deptId) {
                $q->where('department_id', $deptId)->where('type', 'intern');
            })
            ->with('user')
            ->orderBy('due_date')
            ->paginate(15)
            ->appends($query);

        return Inertia::render('Supervisor/Tasks/index', [
            'tasks' => $tasks,
            'query' => $query,
        ]);
    }

    public function intern(User $intern)
    {
        $user = Auth::user();
        if ($user->type !== 'supervisor') {
            abort(403);
        }

        $deptId = $user->department_id;

        if (is_null($deptId) || $intern->department_id !== $deptId || $intern->type !== 'intern') {
            abort(403);
        }

        $intern->load(['reports.user', 'department']);

        $reports = $intern->reports()
            ->with('user')
            ->orderBy('created_at', 'desc')
            ->paginate(15);

        return Inertia::render('Supervisor/Interns/show', [
            'intern' => $intern,
            'reports' => $reports,
        ]);
    }

    public function showTask(Task $task)
    {
        $user = Auth::user();
        if ($user->type !== 'supervisor') {
            abort(403);
        }

        $deptId = $user->department_id;

        if (is_null($deptId) || $task->user->department_id !== $deptId || $task->user->type !== 'intern') {
            abort(403);
        }

        $task->load('user');

        return Inertia::render('Supervisor/Tasks/show', [
            'task' => $task,
        ]);
    }

    public function showReport(Report $report)
    {
        $user = Auth::user();
        if ($user->type !== 'supervisor') {
            abort(403);
        }

        $deptId = $user->department_id;

        if (is_null($deptId) || $report->user->department_id !== $deptId || $report->user->type !== 'intern') {
            abort(403);
        }

        $report->load('user');

        return Inertia::render('Supervisor/Reports/show', [
            'report' => $report,
        ]);
    }
}

