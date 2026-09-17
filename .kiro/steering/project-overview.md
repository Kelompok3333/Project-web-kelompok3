# Laravel Clinic Management Project

This repository is a Laravel application for a clinic / hospital management system.

## Tech stack

- PHP + Laravel
- Composer for PHP dependencies
- Vite + Laravel Mix-style asset pipeline (`vite.config.js`)
- MySQL or compatible database via Laravel config
- Blade templates in `resources/views`

## Important commands

- Install dependencies:
    - `composer install`
    - `npm install`
- Run app locally:
    - `php artisan serve`
    - `npm run dev`
- Run migrations:
    - `php artisan migrate`
- Run tests:
    - `php artisan test`

## Project structure

- `app/` — application logic, controllers, models, middleware
- `config/` — Laravel configuration
- `database/migrations/` — schema changes
- `database/seeders/` — seed data
- `resources/views/` — Blade templates
- `routes/` — web and API routes
- `tests/` — automated tests

## Development guidance

- Prefer Laravel conventions: controllers, models, migrations, policies, requests, and resources.
- Keep business logic in service classes or proper Laravel layers when needed.
- Validate request input with Form Requests when the flow is complex.
- Use Eloquent relationships instead of raw query work when possible.
- Maintain consistent naming in Indonesian/English based on existing project conventions.
- When making changes, prefer small and focused edits that follow the current app structure.

## Key notes

- This is an internal clinic administration app; do not assume a generic SaaS template.
- Some features may involve doctor schedules, patient profiles, queue numbers, appointments, and visit history.
- Keep changes aligned with existing Laravel patterns and the project’s current naming conventions.
