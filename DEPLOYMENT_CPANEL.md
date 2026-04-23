# cPanel VPS Deployment

## Upload

Upload this project to:

```text
/home/CPANEL_USER/project_backup
```

Point the domain document root to:

```text
/home/CPANEL_USER/project_backup/public
```

If cPanel forces `public_html`, copy only the contents of `public/` into `public_html`, then edit `public_html/index.php`:

```php
require __DIR__.'/../project_backup/vendor/autoload.php';
$app = require_once __DIR__.'/../project_backup/bootstrap/app.php';
```

## Environment

Copy `.env.cpanel.example` to `.env` on the server and update:

- `APP_URL`
- `APP_KEY`
- `DB_DATABASE`
- `DB_USERNAME`
- `DB_PASSWORD`
- mail settings

If this is a migrated live database, keep the original `APP_KEY`.

## Commands

Run from the project root:

```bash
composer install --no-dev --optimize-autoloader
php artisan migrate --force
php artisan storage:link
php artisan optimize:clear
php artisan config:cache
php artisan route:cache
php artisan view:cache
```

If `APP_KEY` is empty and this is a fresh install:

```bash
php artisan key:generate
```

## Permissions

```bash
chmod -R 775 storage bootstrap/cache
```

If needed:

```bash
chown -R CPANEL_USER:CPANEL_USER /home/CPANEL_USER/project_backup
```

## Checks

```bash
php artisan route:list
php artisan migrate:status
```

The project installer, external updater, developer license screens, and external marketplace calls are disabled. The marketplace reads local add-ons and themes from the project files.
