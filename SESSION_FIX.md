# Quick Fix for Session Error

## Problem
You're getting this error:
```
SQLSTATE[42S02]: Base table or view not found: 1146 Table 'laravel_school_db_sp.sessions' doesn't exist
```

## Solution
Change your session driver from `database` to `file` in the `.env` file.

## Instructions

### Option 1: Manual Edit
Open your `.env` file and change this line:
```env
SESSION_DRIVER=database
```

To:
```env
SESSION_DRIVER=file
```

### Option 2: Using Command Line
Run this command:
```bash
sed -i 's/SESSION_DRIVER=database/SESSION_DRIVER=file/' .env
```

## After Fix
1. Clear your application cache:
   ```bash
   php artisan config:clear
   php artisan cache:clear
   ```

2. Try logging in again at `http://localhost:8000/student/login`

## Why This Works
- **File sessions** store session data in files (in `storage/framework/sessions/`)
- **Database sessions** require a `sessions` table in your database
- Since you can't create extra tables, file sessions are the perfect solution
- File sessions work just as well for authentication!

## Alternative Session Drivers (if needed)
- `file` - Stores sessions in files (recommended for your case)
- `cookie` - Stores sessions in encrypted cookies
- `array` - For testing only (sessions don't persist)
