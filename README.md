# Just Dental Clinic — Management System

A Laravel 11 clinic management system for **Just Dental Clinic**: online appointment
booking, patient & dental records, an interactive tooth chart, inventory, PayMongo
payments, invoices, notifications, real‑time messaging, reviews, and an optional AI
dental assistant.

> White‑label: all clinic‑specific identity (name, contact, hours, branding, SEO,
> appointment/payment rules) lives in **`config/clinic.php`** and is driven by
> environment variables — nothing clinic‑specific is hardcoded in views or controllers.

## Tech stack

- **Backend:** Laravel 11 · PHP 8.2
- **Database:** MySQL 8 (primary) · MongoDB (chat messages) · Redis (optional cache/queue)
- **Frontend:** Blade · Vite · TailwindCSS · Alpine.js · Chart.js/ApexCharts
- **Integrations:** PayMongo (payments) · Pusher (real‑time) · Laravel Socialite (Google/Facebook OAuth) · Groq (AI assistant) · reCAPTCHA

## Quick start (Docker — recommended)

The repo ships a Docker stack (PHP + MySQL + MongoDB + Redis) so no local PHP is needed.

```bash
docker compose up -d --build
docker compose exec app composer install
cp .env.example .env
docker compose exec app php artisan key:generate
docker compose exec app php artisan migrate --seed
docker compose exec app php artisan storage:link
npm install && npm run build            # Node runs on the host
docker compose exec app php artisan serve --host=0.0.0.0 --port=8000
```

Then open **http://localhost:8000**.

The Docker `.env` should point at the service hostnames: `DB_HOST=mysql`,
`MONGO_DSN=mongodb://mongo:27017`, `REDIS_HOST=redis`. See [docs/INSTALLATION.md](docs/INSTALLATION.md).

### Demo accounts (local only — never ship to production)

| Role  | Email                        | Password   |
|-------|------------------------------|------------|
| Admin | admin@justdental.example     | `password` |
| Patient | juan.demo@justdental.example | `password` |

Demo patients (`Juan Demo`, `Maria Sample`, `Test Patient`) are clearly fictional.
No fabricated medical records are seeded.

## Configuration

Clinic identity, contact details, operating hours, currency, and appointment/payment
rules are configured in **[`config/clinic.php`](config/clinic.php)** via `CLINIC_*`
environment variables. Values marked `TODO: supplied by clinic` must be filled in
before production. See [docs/CONFIGURATION.md](docs/CONFIGURATION.md).

## Documentation

- [docs/INSTALLATION.md](docs/INSTALLATION.md) — local setup (Docker & native)
- [docs/CONFIGURATION.md](docs/CONFIGURATION.md) — clinic config & integrations
- [docs/DEPLOYMENT.md](docs/DEPLOYMENT.md) — production deployment
- [docs/SECURITY.md](docs/SECURITY.md) — security model & hardening checklist
- [docs/ADMIN_GUIDE.md](docs/ADMIN_GUIDE.md) — day‑to‑day admin usage

## Testing

```bash
docker compose exec app php artisan test
```

## License

Released under the [MIT License](LICENSE).
