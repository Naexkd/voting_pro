# Secure Online Voting System Setup

## Requirements
- PHP 8.2 or later
- Composer
- MySQL or another supported database
- Node.js/npm (for frontend assets)

## Install dependencies

1. Copy environment file:
   ```bash
   cp .env.example .env
   ```
2. Update `.env` with your database credentials and `APP_KEY`.
3. Install PHP dependencies:
   ```bash
   composer install
   ```
4. Install frontend dependencies:
   ```bash
   npm install
   ```

## Database setup

1. Run migrations and seed initial data:
   ```bash
   php artisan migrate --seed
   ```

2. Optionally, if you want to use the SQL script directly, run:
   ```sql
   -- Use the voting_db database and execute database/secure_voting_schema.sql
   ```

## Run locally

```bash
php artisan serve
npm run dev
```

Open the app at `http://127.0.0.1:8000`.

## Test account

- Username: `testuser`
- Password: `password`

The seeded test user also has a linked voter profile and sample candidates.
