# Fix Inertia.js Interns Page Error (null.toString() in mergeDataIntoQueryString)

## Approved Plan Implementation Steps:
- [x] 1. Create/update TODO.md with progress tracking
- [x] 2. Edit app/Http/Controllers/SupervisorController.php: Add 'query' => [] to no-department returns in interns(), reports(), tasks()
- [x] 3. Update TODO.md after controller edit (mark complete)
- [ ] 4. Test navigation/filtering/pagination on /supervisor/interns as supervisor without dept_id
- [ ] 5. Test reports/tasks pages
- [ ] 6. Run `php artisan serve` and verify in browser: login -> interns (no crash), submit empty search, paginate
- [ ] 7. Complete task

**Status**: Added prop defaults to Interns/Reports/Tasks .vue (query/flash always {}). Added `link.url ?? '#'` to Interns pagination Link to match other pages. Fixes Inertia preserve-query on null paginator links. Hard refresh (Ctrl+F5), test interns page load/filter/paginate.
