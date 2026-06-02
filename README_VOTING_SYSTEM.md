# Secure Online Voting System

A transparent, secure, and instant online voting system for Gasabo District elections built with Laravel 12.

## Features

✅ **Secure Authentication** - Password hashing with bcrypt and session-based authentication  
✅ **Voter Registration** - Voters register with username, email, and national ID  
✅ **One Voter, One Vote** - Strict database constraints prevent duplicate votes  
✅ **Real-Time Results** - Live vote aggregation and transparent results display  
✅ **User-Friendly Interface** - Clean Tailwind CSS-based UI  

## Tech Stack

- **Backend**: PHP 8.2+ / Laravel 12
- **Frontend**: Blade Templates, Tailwind CSS
- **Database**: SQLite (configurable to MySQL/PostgreSQL)
- **Build Tools**: Vite, npm

## Project Structure

```
├── app/
│   ├── Http/
│   │   ├── Controllers/
│   │   │   ├── VoteController.php       # Handle voting
│   │   │   ├── ResultController.php     # Display results
│   │   │   └── Auth/                    # Authentication controllers
│   │   └── Requests/
│   └── Models/
│       ├── User.php                      # System users (voters)
│       ├── Voter.php                     # Voter profile with national_id
│       ├── Candidate.php                 # Election candidates
│       └── Vote.php                      # Cast votes
├── database/
│   ├── migrations/                       # Database migrations
│   ├── seeders/                          # Database seeders
│   └── secure_voting_schema.sql          # Full SQL schema
├── resources/
│   └── views/
│       ├── vote.blade.php                # Voting ballot
│       ├── results.blade.php             # Election results
│       ├── dashboard.blade.php           # User dashboard
│       ├── auth/                         # Authentication views
│       └── layouts/                      # Layout components
└── routes/
    ├── web.php                           # Web routes
    └── auth.php                          # Authentication routes
```

## Database Schema

### Users Table
Stores system users with hashed passwords.

```
- id (PK)
- name
- username (unique)
- email (unique, optional)
- password (hashed)
- email_verified_at (nullable)
- remember_token (nullable)
- timestamps
```

### Voters Table
Links users to voter profiles with national ID.

```
- voter_id (PK)
- user_id (FK → users, nullable)
- name
- national_id (unique)
- timestamps
```

### Candidates Table
Election candidates and positions.

```
- candidate_id (PK)
- name
- position
- timestamps
```

### Votes Table
Cast votes with one-vote-per-voter constraint.

```
- vote_id (PK)
- voter_id (FK → voters, unique constraint)
- candidate_id (FK → candidates)
- timestamps
```

## Installation

### Prerequisites

- PHP 8.2 or later
- Composer
- Node.js & npm
- SQLite (or MySQL/PostgreSQL)

### Setup Steps

1. **Clone/Enter the project**
   ```bash
   cd c:\xampp\htdocs\voting_system
   ```

2. **Copy environment file**
   ```bash
   copy .env.example .env
   ```

3. **Generate app key**
   ```bash
   php artisan key:generate
   ```

4. **Install dependencies**
   ```bash
   composer install
   npm install
   ```

5. **Run migrations & seeders**
   ```bash
   php artisan migrate --seed
   ```
   This will:
   - Create all tables (users, voters, candidates, votes, sessions, etc.)
   - Seed test user and sample candidates

6. **Build frontend assets**
   ```bash
   npm run build
   ```

## Running the Application

### Development Mode
```bash
# Terminal 1: Start Laravel server
php artisan serve

# Terminal 2: Watch CSS/JS changes
npm run dev
```

Access the app at `http://127.0.0.1:8000`

### Production Mode
```bash
npm run build
php artisan serve
```

## Test Account

**Username**: `testuser`  
**Password**: `password`

This account includes a linked voter profile with national ID `RWA-0000000001` and is ready to cast a vote.

## Sample Candidates (Seeded)

1. **Alice Uwase** - District Mayor
2. **Benjamin Nkurunziza** - District Mayor
3. **Clarisse Mukamana** - Councilor
4. **David Mugisha** - Councilor

## User Workflow

### 1. Registration
- Navigate to `/register`
- Enter name, username, email, national ID
- Create password
- System creates both User and Voter records

### 2. Login
- Navigate to `/login`
- Enter username and password
- Access dashboard and voting features

### 3. Voting
- Click "Vote Now" on dashboard
- See all candidates by position
- Select a candidate via radio button
- Submit to cast vote (one-time only)

### 4. View Results
- Click "View Results" on dashboard
- See real-time vote counts per candidate
- Ordered by vote count (descending)

## API Routes

### Authentication
- `GET /register` - Registration form
- `POST /register` - Submit registration
- `GET /login` - Login form
- `POST /login` - Submit login
- `POST /logout` - Logout (auth required)

### Voting
- `GET /vote` - View ballot (auth required)
- `POST /vote` - Submit vote (auth required)

### Results
- `GET /results` - View election results (auth required)

### Dashboard
- `GET /dashboard` - User dashboard (auth required)
- `GET /` - Home page (public)

## Key Security Features

1. **Password Hashing**: All passwords hashed with bcrypt (12 rounds)
2. **CSRF Protection**: All forms protected with CSRF tokens
3. **Database Constraints**: Unique constraint on `votes.voter_id` enforces one-vote-per-voter
4. **Authentication Middleware**: All voting/results pages require login
5. **Rate Limiting**: Login attempts rate-limited (5 attempts per minute)
6. **Prepared Statements**: Laravel ORM prevents SQL injection

## Business Logic

### One Voter, One Vote Enforcement
```php
// Checked before vote submission in VoteController
if (Vote::where('voter_id', $voter->voter_id)->exists()) {
    // Already voted - redirect with error
}

// Database unique constraint ensures no duplicates
UNIQUE KEY one_vote_per_voter (voter_id)
```

### Vote Counting
```php
// Real-time aggregation in ResultController
Candidate::withCount(['votes as vote_count'])
    ->orderByDesc('vote_count')
    ->orderBy('name')
    ->get();
```

## Troubleshooting

### "View [welcome] not found"
- Ensure `resources/views/welcome.blade.php` exists
- Run: `php artisan view:clear`

### "View [vote] not found"
- Check that vote.blade.php exists in resources/views/
- Run: `php artisan view:clear`

### Database migration errors
- Ensure `.env` has correct database credentials
- For SQLite: check that `database/database.sqlite` exists and is writable
- Run: `php artisan migrate:reset --seed` (clears and rebuilds)

### Session/authentication issues
- Clear sessions: `php artisan session:table` (if using database sessions)
- Run: `php artisan cache:clear && php artisan config:clear`

## Environment Variables

Key `.env` settings:

```
DB_CONNECTION=sqlite              # Database type
APP_DEBUG=true                    # Debug mode (set to false in production)
SESSION_DRIVER=database           # Store sessions in DB
APP_NAME="Voting System"          # Application name
```

## Migration & Rollback

### Run migrations
```bash
php artisan migrate
```

### Rollback last migration
```bash
php artisan migrate:rollback
```

### Fresh install (reset all)
```bash
php artisan migrate:fresh --seed
```

## Contributing

For future enhancements:
- Add candidate images/profiles
- Implement admin dashboard for election management
- Add email notifications
- Create PDF election reports
- Multi-language support

## License

MIT License - See LICENSE file for details

---

**Organization**: Gasabo District  
**Purpose**: Secure online voting with transparency and instant results  
**Built**: May 2026
