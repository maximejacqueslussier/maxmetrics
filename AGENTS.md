# Repository Guidelines

## Project Intent (Kata)
This project is a kata. Prioritize clarity, learning value, and maintainable structure over premature optimization.

- The core UX is a multi-page health dashboard where widgets link to dedicated detail pages.
- Detail pages should support deeper insights, including filters, date ranges, and historical views.
- Keep backend business logic in `Domain`/`Application`; keep GraphQL wiring in `GraphQL`.
- Treat the owned SQLite database as the source of truth for personal/user-specific data.
- Integrate Google Fit, Pixel Watch, and Fitbit through interfaces/adapters so providers are replaceable and mockable.

## Project Structure & Module Organization
This repository has two apps:

- `backend/`: Symfony 7.4 GraphQL API (`src/Application`, `src/Domain`, `src/GraphQL`, `src/Controller`), config in `config/`, schema/data migrations in `migrations/`, and SQLite files in `data/`.
- `frontend/`: React 19 + Vite client. App code lives in `src/` (feature UI under `src/components/*`), static assets in `public/`, production output in `dist/`.

Keep backend business rules in `Domain`/`Application`, and GraphQL-specific wiring in `GraphQL`.

## Build, Test, and Development Commands
Run commands from each app directory.

- Frontend setup: `cd frontend && npm install`
- Frontend dev server: `npm run dev`
- Frontend production build: `npm run build`
- Frontend lint: `npm run lint`
- Backend setup: `cd backend && composer install`
- Backend console: `php bin/console`
- Run DB migrations: `php bin/console doctrine:migrations:migrate`
- Backend style check: `vendor/bin/phpcs`

If Symfony CLI is available, use `symfony server:start` in `backend/` for local API serving.

## Coding Style & Naming Conventions
- PHP follows PSR-12 via `backend/phpcs.xml.dist`; use 4-space indentation (see `backend/.editorconfig`).
- PHP classes use PascalCase and match file names (for example, `ListUsers.php`).
- React components use PascalCase filenames (`Navbar.jsx`, `Layout.jsx`); hooks/utils should use camelCase.
- Keep modules focused: one component/class responsibility per file.

## Testing Guidelines
There is currently no committed automated test suite in this repository. Minimum validation before PR:

- `frontend`: `npm run lint` and manual UI smoke test.
- `backend`: `vendor/bin/phpcs`, migration check, and GraphQL endpoint smoke test.

When adding tests, place backend tests in `backend/tests/` and frontend tests in `frontend/src/__tests__/`.

## Commit & Pull Request Guidelines
Current history uses short imperative summaries (for example, “Refactor the user management.”). Follow that style:

- Commit subject: imperative, concise, and scoped (`frontend: add dashboard header`).
- PRs should include: purpose, changed areas (`backend`/`frontend`), migration impact, and screenshots for UI updates.
- Link related issues/tasks and list manual verification steps.

## Security & Configuration Tips
- Never commit secrets; use `.env.local` for local overrides.
- Treat `backend/data/*.db` as local/dev data unless explicitly preparing fixtures/migrations.
