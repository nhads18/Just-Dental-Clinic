# Installation

## Requirements

- PHP 8.2+ with extensions: `pdo_mysql`, `mongodb` (1.x), `redis`, `gd`, `zip`,
  `bcmath`, `intl`, `mbstring`, `exif`, `openssl`
- Composer 2
- Node.js 20+ and npm
- MySQL 8, MongoDB (for chat), Redis (optional)

## Option A — Docker (recommended)

The repo includes `docker-compose.yml` + `docker/php/` providing PHP 8.2 (with all
required extensions) plus MySQL 8, MongoDB, and Redis. Node runs on the host.

```bash
docker compose up -d --build

# PHP dependencies
docker compose exec app composer install

# Environment
cp .env.example .env
# Point the app at the Docker services:
#   DB_HOST=mysql   DB_DATABASE=justdental   DB_USERNAME=justdental   DB_PASSWORD=secret
#   MONGO_DSN=mongodb://mongo:27017          REDIS_HOST=redis
docker compose exec app php artisan key:generate

# Database
docker compose exec app php artisan migrate --seed
docker compose exec app php artisan storage:link

# Frontend assets (host)
npm install
npm run build

# Serve
docker compose exec app php artisan serve --host=0.0.0.0 --port=8000
```

Open http://localhost:8000.

### Notes for the Docker dev server

- `php artisan serve` is single‑threaded; the **first** request after start compiles
  the framework (several seconds) and briefly refuses overlapping connections. Wait
  for the first `/up` to return before load‑testing.
- Opcache is enabled with `validate_timestamps=0` for speed over the Windows bind
  mount — **restart the server after editing PHP files** so changes take effect
  (`docker compose restart app` then re‑run `php artisan serve`).

## Option B — Native

```bash
composer install
cp .env.example .env
php artisan key:generate
# Configure DB_*, MONGO_*, mail, etc. in .env
php artisan migrate --seed
php artisan storage:link
npm install && npm run build
php artisan serve
```

## Verifying the install

```bash
php artisan about            # should boot cleanly
php artisan route:list       # ~168 routes, no errors
php artisan migrate:status   # all "Ran"
php artisan test             # test suite
```

## Troubleshooting

- **`Vite manifest not found`** — run `npm run build`. The manifest is written to
  `public/build/manifest.json`.
- **`Driver [database] not supported` at boot** — ensure `config/app.php`’s
  `maintenance.driver` reads `APP_MAINTENANCE_DRIVER` (fixed in this codebase) and
  `APP_MAINTENANCE_DRIVER=file` in `.env`.
- **MongoDB errors** — the PHP `mongodb` extension must be **1.x** to match the
  locked `mongodb/mongodb` library.
