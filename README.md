# srms
school result management system

## Phase 1: Identity, Authentication & RBAC

This repository now includes the initial foundation for the Phase 1 scope:

- school model and database table
- user model with role/permission helpers
- role and permission models and migrations
- login/logout routes and auth views
- RBAC middleware for active-user and permission checks
- demo school and permission seeders
- basic authentication and authorization tests

## Important notes

This implementation is intentionally kept focused on the core security and identity foundation required by the implementation plan. The remaining school modules will be added in later phases according to the project plan.

## Project status

- [x] Phase 0 project initialization
- [x] Phase 1 identity and RBAC foundation
- [ ] Phase 2 school and academic configuration
- [ ] Phase 3 students and guardians
- [ ] Phase 4 staff and teacher management
- [ ] Phase 5 subjects, enrollment and registration
- [ ] Phase 6 dashboards
- [ ] Phase 7 timetable
- [ ] Phase 8 attendance
- [ ] Phase 9 assessment configuration
- [ ] Phase 10 score entry
- [ ] Phase 11 results and report cards
- [ ] Phase 12 promotion and graduation
- [ ] Phase 13 admissions
- [ ] Phase 14 finance foundation
- [ ] Phase 15 payments and expenses
- [ ] Phase 16 communication
- [ ] Phase 17 requests
- [ ] Phase 18 reports
- [ ] Phase 19 audit and security hardening
- [ ] Phase 20 UX polish
- [ ] Phase 21 QA and regression
- [ ] Phase 22 deployment readiness

## Quick start

1. Install Composer dependencies.
2. Install npm dependencies.
3. Copy `.env.example` to `.env` and configure your MySQL database.
4. Run `php artisan key:generate`.
5. Run migrations and seeders.
6. Access `/login` using the seeded admin account:
   - username: `admin`
   - password: `password123`

## Security reminder

Follow the implementation plan strictly. Do not bypass authorization, and do not silently weaken business rules in the pursuit of UI convenience.
