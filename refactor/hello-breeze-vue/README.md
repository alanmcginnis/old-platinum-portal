# Hello‑World Milestone: Laravel Breeze + Vue Spike

This directory is a sandbox for the initial Laravel + Breeze + Vue proof‑of‑concept. It is completely isolated from the legacy codebase. Once validated, final integration will be merged into the refactored project.

## Setup

1. **Change directory** into this spike folder:
   ```bash
   cd refactor/hello-breeze-vue
   ```
2. **Install dependencies** (assuming Laravel has been created here):
   ```bash
   composer install
   npm install
   npm run dev
   ```
3. **Configure environment**:
   Copy `.env.example` to `.env`. Update `APP_URL` to your local dev URL (e.g., `http://127.0.0.1:8000`), and update DB credentials for MySQL.
   Then generate an application key and clear the config cache:
   ```bash
   php artisan key:generate
   php artisan config:clear
   ```
4. **Run migrations**:
   ```bash
   php artisan migrate
   ```
5. **Seed default users** (creates Test User + Dev Admin):
   ```bash
   php artisan db:seed
   ```

6. **Serve locally**:
   ```bash
   php artisan serve
   ```
6. **Verify**: Visit http://127.0.0.1:8000 and confirm the Breeze login/register UI.

## Next Steps

- Study the generated `routes/web.php`, `resources/views`, and `resources/js/Pages` to see how Blade and Vue interoperate.
- Scaffold a simple CRUD (e.g., Vendors) to replicate an existing module.
- To change a seeded user’s password in dev, use Tinker or the password-reset flow:

```bash
php artisan tinker
>>> use App\Models\User; use Illuminate\Support\Facades\Hash;
>>> $user = User::where('email', 'test@example.com')->first();
>>> $user->password = Hash::make('your-new-password');
>>> $user->save();
```

Or visit `/forgot-password` and submit `test@example.com` to log the reset link (MAIL_MAILER=log).

## Local Database Setup

### Prerequisites

- MySQL client (`mysql`) must be installed and in your PATH. On macOS, install via Homebrew:
  ```bash
  brew install mysql
  ```
- If you use MAMP, Laragon, Docker, or another VM/container, ensure the `mysql` CLI is accessible in your environment.

To import and inspect your database dump as defined in `localhost.sql`, you have two options:

### A) Full multi‑DB import

This will create and populate all original databases (`platinumind_accounting`, `platinumind_timesheet`, `platinumind_website`):

```bash
mysql -u root -p < /path/to/localhost.sql
```

### B) Import only the accounting schema into one DB

If you prefer to load just the `platinumind_accounting` section into your local `platinum` database:

#### 1) Using the `--one-database` option

```bash
mysql -u root -p --one-database=platinumind_accounting platinum \
  < /path/to/localhost.sql
```

#### 2) Stripping CREATE/USE statements with `sed`

```bash
sed -e 's/CREATE DATABASE.*;//g' \
    -e 's/USE `[^`]*`;//g' \
    /path/to/localhost.sql \
  | mysql -u root -p platinum
```

### 2. Connect with Sequel Ace

In Sequel Ace, create a Standard connection:

| Field    | Value                   |
|----------|-------------------------|
| Host     | 127.0.0.1               |
| User     | root                    |
| Password | (your MySQL password)   |
| Port     | 3306                    |
| Database | platinum                |

### 3. (Optional) Configure the Laravel Spike

Edit `refactor/hello-breeze-vue/.env` to configure multiple DB connections:

```ini
# Primary database (accounting)
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=platinumind_accounting
DB_USERNAME=root
DB_PASSWORD=(your MySQL password)

# Secondary database (timesheets)
DB_TIMESHEET_HOST=127.0.0.1
DB_TIMESHEET_PORT=3306
DB_TIMESHEET_DATABASE=platinumind_timesheet
DB_TIMESHEET_USERNAME=root
DB_TIMESHEET_PASSWORD=(your MySQL password)

# Tertiary database (website)
DB_WEBSITE_HOST=127.0.0.1
DB_WEBSITE_PORT=3306
DB_WEBSITE_DATABASE=platinumind_website
DB_WEBSITE_USERNAME=root
DB_WEBSITE_PASSWORD=(your MySQL password)
```