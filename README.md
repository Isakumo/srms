# School Result Management System (SRMS)

A Laravel-based school management system for Nursery, Primary, Junior Secondary, and Senior Secondary operations.

## Project status

This repository has been initialized to support the implementation plan in `SCHOOL_MANAGEMENT_SYSTEM_IMPLEMENTATION_PLAN.md`.

## Phase 0 status

- [x] Repository initialized
- [x] Laravel app skeleton created
- [x] Environment example configured
- [x] Frontend tooling configured for Tailwind + Alpine
- [x] Test runner configured
- [x] Implementation checklist created

## Stack

- Laravel
- MySQL / InnoDB
- Blade + Tailwind CSS + Alpine.js
- PHPUnit

## Local setup

1. Install PHP 8.2+ and Composer.
2. Install Node.js and npm.
3. Run:
   ```bash
   composer install
   npm install
   cp .env.example .env
   php artisan key:generate
   ```
4. Update database credentials in `.env`.
5. Run database migrations and seeders when ready:
   ```bash
   php artisan migrate
   php artisan db:seed
   ```

## Documentation

- Implementation plan: `SCHOOL_MANAGEMENT_SYSTEM_IMPLEMENTATION_PLAN.md`
- Phase checklist: `IMPLEMENTATION_CHECKLIST.md`

## Notes

This repo is intentionally structured to follow the implementation plan in phases. Development is expected to continue from Phase 1 after the foundation is validated.
