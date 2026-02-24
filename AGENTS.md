# AGENTS.md

## Cursor Cloud specific instructions

### Overview

**らくカケ (RakuKake)** — Laravel 10 + Inertia.js/React の家計管理APIバックエンド。フロントエンドSPAは別リポジトリ (`rakukake-web-front.pages.dev`)。

### Services

| Service | Required | Notes |
|---------|----------|-------|
| PHP 8.2 (Laravel) | Yes | `php artisan serve --host=0.0.0.0 --port=8000` |
| MySQL 8.0 | Yes | DB: `goal_app` (app), `testing` (tests) |
| Node.js / npm | Dev only | Frontend asset build (`npm run dev`) |

### MySQL startup (Cloud VM)

MySQL must be started manually in the Cloud VM before running tests or the app:

```bash
sudo mysqld --user=mysql --datadir=/var/lib/mysql --socket=/var/run/mysqld/mysqld.sock --pid-file=/var/run/mysqld/mysqld.pid &
sleep 3
sudo chmod 755 /var/run/mysqld && sudo chmod 777 /var/run/mysqld/mysqld.sock
```

### Running commands

- **Dev server:** `php artisan serve --host=0.0.0.0 --port=8000`
- **Tests:** `php artisan test` (unit tests pass; some feature tests fail due to missing `resources/js/` — see below)
- **Lint:** `./vendor/bin/pint --test`
- **Migrations:** `php artisan migrate`

### Known caveats

- `resources/js/` and `vite.config.js` are absent from this repo. Inertia view-rendering feature tests (Auth, Profile) return 500. Unit tests and non-rendering feature tests work fine.
- API routes under `/api/v1/` do not have `auth:sanctum` middleware in route definitions. They rely on `AuthService::getCurrentUserId()` which reads `auth()->user()`. For curl testing, use `php artisan tinker` to create a Sanctum token and pass it as `Authorization: Bearer <token>`.
- The `.env.example` ships with `DB_PASSWORD=` (empty). MySQL root user is configured with empty password.
