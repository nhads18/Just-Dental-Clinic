# Just Dental Clinic - Production Ready Application

A comprehensive dental clinic management system built with Laravel 11, PHP 8.2, MySQL 8, MongoDB 7, and Redis 7.

## Features

- **Patient Management**: Complete patient records, appointment scheduling, and dental history
- **Inventory Management**: Advanced tracking with box/piece units, expiration dates, and low-stock alerts
- **Appointment System**: Real-time booking, rescheduling, cancellations, and status tracking
- **Admin Dashboard**: Comprehensive analytics, user management, and system oversight
- **Dental Records**: Tooth-by-tooth charting with images and notes
- **Messaging System**: Real-time patient-admin communication via MongoDB
- **AI Assistant**: Lee AI chatbot for patient inquiries
- **Authentication**: Email verification, Google OAuth, and secure password handling
- **Activity Logging**: Complete audit trail for all system actions

## Docker Setup (Recommended)

### Prerequisites
- Docker & Docker Compose installed
- Git installed

### Quick Start

```bash
# 1. Clone the repository
cd /workspace

# 2. Create environment file
cp .env.example .env

# 3. Start all services
docker compose up -d --build

# 4. Install PHP dependencies
docker compose exec app composer install

# 5. Generate application key
docker compose exec app php artisan key:generate

# 6. Run database migrations
docker compose exec app php artisan migrate --seed

# 7. (Optional) Fix any legacy database issues
docker compose exec app php fix-ratings-db.php

# 8. Access the application
# Open http://localhost:8000 in your browser
```

### Services

| Service | Port | Description |
|---------|------|-------------|
| App (PHP 8.2) | 8000 | Laravel application |
| MySQL 8 | 3306 | Primary database |
| MongoDB 7 | 27017 | Message storage |
| Redis 7 | 6379 | Sessions & cache |

### Common Commands

```bash
# View logs
docker compose logs -f app

# Run artisan commands
docker compose exec app php artisan <command>

# Run composer commands
docker compose exec app composer <command>

# Restart services
docker compose restart

# Stop all services
docker compose down

# Rebuild containers
docker compose build --no-cache
```

## Environment Configuration

Edit `.env` file with your settings:

```env
APP_NAME="Just Dental Clinic"
APP_URL=http://localhost:8000

# Database
DB_HOST=mysql
DB_DATABASE=justdental
DB_USERNAME=justdental
DB_PASSWORD=secret

# MongoDB
MONGO_DSN=mongodb://mongo:27017
MONGO_DATABASE=justdental_messages

# Redis
REDIS_HOST=redis
REDIS_PORT=6379
```

## Inventory Management

The system uses an advanced inventory tracking model:

- **quantity**: Number of full/unopened boxes
- **items_per_unit**: How many individual pieces in one unit (e.g., 100 masks per box)
- **original_items_per_unit**: Constant reference value (never changes)
- **current_box_pieces**: Pieces remaining in the currently open box

### Unit Types Supported
- Pieces
- Boxes
- Packs
- Bottles
- Sets
- Rolls
- Pairs
- Tubes

### Expiration Tracking
- **Expirable**: Requires expiration date
- **Inexpirable**: No expiration date needed (e.g., equipment)

## Security Considerations

1. **Production Environment**:
   - Set `APP_DEBUG=false`
   - Set `SESSION_SECURE_COOKIE=true`
   - Enable HTTPS and update `APP_URL`
   - Change all default passwords

2. **User Roles**:
   - Admin users have `usertype='admin'`
   - Regular patients have `usertype='patient'`
   - User type cannot be mass-assigned (security measure)

3. **Data Protection**:
   - Passwords are hashed using bcrypt
   - CSRF protection enabled on all forms
   - SQL injection prevention via Eloquent ORM

## Troubleshooting

### Common Issues

**Database Connection Error:**
```bash
docker compose restart mysql
docker compose exec app php artisan config:clear
```

**Permission Issues:**
```bash
docker compose exec app chmod -R 775 storage bootstrap/cache
```

**Migration Errors:**
```bash
docker compose exec app php artisan migrate:fresh --seed
```

**Cache Issues:**
```bash
docker compose exec app php artisan cache:clear
docker compose exec app php artisan config:clear
docker compose exec app php artisan view:clear
```

## Testing

```bash
# Run all tests
docker compose exec app php artisan test

# Run specific test suite
docker compose exec app php artisan test --testsuite=Feature
```

## Deployment Checklist

- [ ] Set `APP_ENV=production`
- [ ] Set `APP_DEBUG=false`
- [ ] Generate production `APP_KEY`
- [ ] Configure HTTPS/SSL
- [ ] Update database credentials
- [ ] Configure backup strategy
- [ ] Set up monitoring/logging
- [ ] Review security headers
- [ ] Test all critical features
- [ ] Document custom configurations

## License

Proprietary - All rights reserved.

## Support

For technical support, contact the development team.
