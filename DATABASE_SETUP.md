# Database Configuration Guide

## Setting Up Database Connection

To enable the student login system, you need to configure your database connection in the `.env` file.

### Step 1: Configure .env File

Open the `.env` file and update the following database settings:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=laravel_school_db_sp
DB_USERNAME=your_mysql_username
DB_PASSWORD=your_mysql_password
```

Replace:
- `your_mysql_username` with your MySQL username (usually `root`)
- `your_mysql_password` with your MySQL password

### Step 2: Verify Database Connection

Test the connection using Laravel Tinker:

```bash
php artisan tinker --execute="DB::connection()->getPdo(); echo 'Database connected successfully!';"
```

### Step 3: Check student_information Table

Verify the table structure:

```bash
php artisan tinker --execute="DB::select('DESCRIBE student_information');"
```

### Step 4: Start the Application

Run the Laravel development server:

```bash
php artisan serve
```

Then visit: `http://localhost:8000/student/login`

## Student Information Table Requirements

The `student_information` table should have at minimum:
- `id` column (student ID for login)
- `password` column (student password)
- Optional: `name`, `email`, `class`, etc.

## Password Security Notes

The system supports both:
1. **Hashed passwords** (recommended) - using bcrypt
2. **Plain text passwords** (fallback) - for compatibility with existing systems

For better security, passwords should be hashed using:
```php
Hash::make('password')
```

## Testing the Login System

1. Navigate to `http://localhost:8000/student/login`
2. Enter a valid student ID from the `student_information` table
3. Enter the corresponding password
4. Click Login
5. You should be redirected to the dashboard

## Troubleshooting

### "Access denied for user" Error
- Check your MySQL credentials in `.env`
- Ensure MySQL service is running

### Table Not Found
- Verify the database name is `laravel_school_db_sp`
- Ensure the `student_information` table exists

### Login Fails with Correct Credentials
- Check if passwords are hashed or plain text
- Verify the column names match (`id` and `password`)
