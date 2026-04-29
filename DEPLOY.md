Hostinger deployment checklist

1. Push code to GitHub and pull on Hostinger (or deploy via GitHub integration).
2. On Hostinger server, set `APP_ENV=production` and proper `.env` values (DB, MAIL, APP_URL).
3. Run PHP dependencies:

```powershell
composer install --no-dev --optimize-autoloader
```

4. Run database migrations and seeders (if needed):

```powershell
php artisan migrate --force
php artisan db:seed --force
```

5. Build frontend assets (if Node available):

```bash
npm ci
npm run build
```

6. Ensure `public/` is the web root and permissions allow web server to read `storage/` and `bootstrap/cache`.
7. Configure scheduler/cron for `php artisan schedule:run` if required.
8. Set up HTTPS and domain (Hostinger panel).

Notes:
- If Composer is not available, install Composer on the server or use `php composer.phar`.
- If Vite build is missing `public/build/manifest.json`, run `npm run build` locally and deploy `public/build`.
