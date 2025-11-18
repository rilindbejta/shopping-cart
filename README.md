# Setup

## Database Setup

Update `.env` with your database credentials:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=shopping_cart
DB_USERNAME=root
DB_PASSWORD=your_password
```

Create the database:

```bash
mysql -u root -p
CREATE DATABASE shopping_cart;
exit;
```

Run migrations and seed data:

```bash
php artisan migrate --seed
```

This creates admin user (admin@example.com / password) and test user (test@example.com / password) plus some sample products.

## Frontend

Install dependencies:

```bash
npm install
npm run build
```

For development:
```bash
npm run dev
```

## Running the App

Start the server:
```bash
php artisan serve
```

Start queue worker (important for notifications):
```bash
php artisan queue:work
```

Access at http://localhost:8000

You can test the daily sales report manually:
```bash
php artisan sales:daily-report
```

## Common Issues

If you get "could not find driver", install PHP MySQL extension:
```bash
sudo apt-get install php-mysql
```

If npm is missing:
```bash
curl -fsSL https://deb.nodesource.com/setup_18.x | sudo -E bash -
sudo apt-get install -y nodejs
```

## Production Notes

For production, set up cron for scheduled tasks:
```bash
* * * * * cd /path-to-project && php artisan schedule:run >> /dev/null 2>&1
```

Use Supervisor to keep queue worker running. Example config:
```ini
[program:laravel-worker]
process_name=%(program_name)s_%(process_num)02d
command=php /path-to-project/artisan queue:work --sleep=3 --tries=3
autostart=true
autorestart=true
user=www-data
numprocs=1
redirect_stderr=true
stdout_logfile=/path-to-project/storage/logs/worker.log
```

