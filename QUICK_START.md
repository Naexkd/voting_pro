# Quick Setup Commands

## Run these commands in your terminal to set up the voting system:

### 1. Install dependencies
```bash
composer install
npm install
```

### 2. Generate app key
```bash
php artisan key:generate
```

### 3. Run migrations and seeders (CRITICAL - Creates database tables and test user)
```bash
php artisan migrate --seed
```

This will:
- Create all database tables (users, voters, candidates, votes, sessions, etc.)
- Create test user: `testuser` / `password`
- Seed 4 sample candidates

### 4. Build frontend assets
```bash
npm run build
```

### 5. Start the application

**Terminal 1 - Start Laravel server:**
```bash
php artisan serve
```

**Terminal 2 - Watch CSS/JS (optional, for development):**
```bash
npm run dev
```

### 6. Access the application
Open: `http://127.0.0.1:8000`

---

## Test the voting system:

1. **Login** at `/login`
   - Username: `testuser`
   - Password: `password`

2. **Go to Dashboard** - See voting status and quick links

3. **Cast a vote** at `/vote`
   - Select a candidate from the ballot
   - Click "Submit Vote"
   - One vote per voter (enforced)

4. **View results** at `/results`
   - See real-time vote counts
   - Candidates ranked by votes

---

## If you get "These credentials do not match" at login:

**You haven't run the migrations yet!** Run:
```bash
php artisan migrate --seed
```

---

## If you see "View not found" errors:

Clear Laravel cache:
```bash
php artisan view:clear
php artisan config:clear
php artisan cache:clear
```

---

## To reset everything (fresh start):

```bash
php artisan migrate:fresh --seed
```

This drops all tables and recreates them with fresh data.

---

**Ready?** Run the 5 commands above and you're good to go! 🚀
