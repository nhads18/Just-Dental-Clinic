# Deployment

## Target architecture (recommended)

- **App:** PHP 8.2 + Nginx/PHP‑FPM (or a managed platform / container)
- **DB:** managed MySQL 8
- **Chat:** MongoDB (only if messaging is kept — otherwise it can be dropped)
- **Cache/Queue/Sessions:** Redis
- **Real‑time:** Pusher (or self‑hosted Reverb/Soketi)
- **Storage:** S3‑compatible bucket; keep `valid_ids` (government IDs) **private**
- **Queue worker + scheduler:** a running `queue:work` and a cron for `schedule:run`

## Environment

1. Copy `.env.example` → `.env` and fill real values. **Never commit `.env` or secrets.**
2. Set:
   ```env
   APP_ENV=production
   APP_DEBUG=false
   APP_URL=https://your-domain
   ```
3. Provide production `DB_*`, `MONGO_*`, `REDIS_*`, `MAIL_*`, `PUSHER_*`,
   `PAYMONGO_*` (LIVE keys), `GROQ_API_KEY`, `RECAPTCHA_*`, and the `CLINIC_*` values.

## Build & release

```bash
composer install --no-dev --optimize-autoloader
php artisan migrate --force
php artisan config:cache
php artisan route:cache
php artisan view:cache
npm ci && npm run build
php artisan storage:link
chmod -R 775 storage bootstrap/cache
```

`deploy-server.sh` is a template that runs the above; configure `DEPLOY_PATH` and
`DEPLOY_BRANCH` for your server (do not hardcode a domain).

## CI/CD

`.github/workflows/deploy.yml` (production) and `deploy-staging.yml` (staging) deploy
over SSH. They read paths/URLs from repository **secrets** — set:

- `SSH_HOST`, `SSH_USERNAME`, `SSH_PORT`, and an SSH **key** (prefer keys/OIDC over passwords)
- `DEPLOY_PATH`, `PUBLIC_HTML_PATH`, `STAGING_PATH`, `REPO_URL`

The production workflow triggers on pushes to `main`.

## Background processes

```bash
php artisan queue:work --tries=3 --timeout=90     # supervised (systemd/supervisor)
# cron (every minute):
* * * * * cd /path/to/app && php artisan schedule:run >> /dev/null 2>&1
```

Scheduled tasks: appointment reminders (every 15 min) and notification cleanup (daily).

## Mail deliverability

Point `MAIL_FROM_ADDRESS` at the clinic domain and configure **SPF/DKIM** for it, or
transactional emails may land in spam.

## Post‑deploy checklist

- [ ] `.env` present, `APP_DEBUG=false`, `APP_KEY` set
- [ ] Migrations run; demo seed data **not** present in production
- [ ] `valid_ids` storage is private (no public URL)
- [ ] HTTPS enforced; HSTS enabled at the edge
- [ ] Queue worker + scheduler running
- [ ] PayMongo LIVE keys set; webhook (if used) configured
- [ ] Backups scheduled to private storage
