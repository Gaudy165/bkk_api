# Repository Guidelines

## Project Structure & Module Organization
- App code: `app/` (e.g., `app/Http/Controllers`, `app/Models`).
- Routes: `routes/web.php` (web) and `routes/api.php` (API).
- Views & assets: `resources/` (Blade, JS, CSS; Vite-managed), public assets in `public/`.
- Config & bootstrap: `config/`, `bootstrap/`. Persisted files in `storage/`.
- Database: `database/migrations`, `database/seeders`.
- Tests: `tests/Feature`, `tests/Unit`.

## Build, Test, and Development Commands
- Install deps: `composer install` and `npm install`.
- One-time setup: `composer run setup` (env, key, migrate, build).
- Dev servers: `composer run dev` (serves Laravel + Vite + queue listener).
- Backend only: `php artisan serve`; Frontend only: `npm run dev`.
- Build assets: `npm run build`.
- Test suite: `composer test` or `php artisan test`.

## Coding Style & Naming Conventions
- PHP: PSR-12 via Pint. Format with `vendor/bin/pint`.
- Indentation: 4 spaces (PHP), 2 spaces (JS/CSS).
- Naming: classes `StudlyCase` in `App\`, methods `camelCase`, constants `UPPER_SNAKE_CASE`.
- Routes/controllers: RESTful names (e.g., `UserController`, `Route::apiResource('users', ...)`).

## Testing Guidelines
- Framework: Pest for Laravel. Place tests under `tests/`.
- Name examples: `tests/Feature/UserApiTest.php`, `tests/Unit/PriceCalculatorTest.php`.
- Run: `composer test`; filter: `php artisan test --filter=UserApi`.
- Prefer feature tests for endpoints; mock externals; seed with factories.

## Commit & Pull Request Guidelines
- Commits: concise, imperative (“Add booking filter”). Group related changes.
- Conventional Commits are welcome (`feat:`, `fix:`, `chore:`) when clear.
- PRs: include purpose, linked issues, instructions to validate, and screenshots for UI.
- Keep PRs small and focused; add tests for new behavior.

## Security & Configuration Tips
- Never commit secrets. Use `.env`; update `.env.example` for new keys.
- Ensure `APP_KEY` is set (`php artisan key:generate`).
- Local DB: SQLite file at `database/database.sqlite` (default), or configure `.env`.
- Run migrations: `php artisan migrate` (add `--seed` if needed).

