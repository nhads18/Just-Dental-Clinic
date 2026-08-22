#!/bin/bash
#
# Just Dental Clinic — server deploy helper (template).
# Configure DEPLOY_PATH and DEPLOY_BRANCH for your environment, e.g. in the
# server's shell profile or a CI secret. Do not hardcode a real domain here.
#
set -e

DEPLOY_PATH="${DEPLOY_PATH:-$HOME/justdental}"
DEPLOY_BRANCH="${DEPLOY_BRANCH:-main}"

cd "$DEPLOY_PATH" || exit 1
git config pull.rebase false
git pull origin "$DEPLOY_BRANCH"
composer install --no-interaction --prefer-dist --optimize-autoloader --no-dev
php artisan migrate --force
php artisan config:cache
php artisan route:cache
php artisan view:cache
chmod -R 775 storage bootstrap/cache
echo "✅ Deployment complete!"
