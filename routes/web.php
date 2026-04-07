<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SupervisorController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

Route::get('/dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::middleware(['auth', 'verified'])->name('supervisor.')->prefix('supervisor')->group(function () {
    Route::get('/dashboard', [SupervisorController::class, 'dashboard'])->name('dashboard');
    Route::get('/submissions', [SupervisorController::class, 'submissions'])->name('submissions.index');
    Route::get('/submissions/{report}', [SupervisorController::class, 'showSubmission'])->name('submissions.show');
    Route::get('/reports', [SupervisorController::class, 'reports'])->name('reports.index');
    Route::get('/interns', [SupervisorController::class, 'interns'])->name('interns.index');
    Route::get('/tasks', [SupervisorController::class, 'tasks'])->name('tasks.index');
});

require __DIR__.'/auth.php';
