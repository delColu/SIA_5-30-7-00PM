# Factory, Seeders, Migrations TODO

## Steps:
- [x] 1. Create migration: add_department_id_to_users_table.php
- [x] 2. Edit app/Models/User.php (add fillable + belongsTo Department)
- [x] 3. Create migration: create_departments_table.php
- [x] 4. Create DepartmentFactory.php
- [x] 5. Create DepartmentSeeder.php
- [x] 6. Edit database/factories/UserFactory.php (add department_id)
- [x] 7. Create UserSeeder.php
- [x] 8. Create create_tasks_table.php migration
- [x] 9. Create TaskFactory.php
- [x] 10. Create TaskSeeder.php
- [x] 11. Create create_activity_logs_table.php migration
- [x] 12. Create ActivityLogFactory.php
- [x] 13. Create ActivityLogSeeder.php
- [x] 14. Create create_reports_table.php migration
- [x] 15. Create ReportFactory.php
- [x] 16. Create ReportSeeder.php
- [x] 17. Edit DatabaseSeeder.php (call all seeders)
- [x] 18. Run `php artisan migrate`
- [x] 19. Run `php artisan db:seed`
- [x] 20. Verify data (tinker or DB tool)

Updated after each step.
