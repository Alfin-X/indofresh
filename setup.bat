@echo off
echo ========================================
echo    IndoFresh Setup Script
echo ========================================
echo.

echo [1/8] Installing Composer Dependencies...
call composer install
if %errorlevel% neq 0 (
    echo Error: Failed to install composer dependencies
    pause
    exit /b 1
)

echo.
echo [2/8] Installing NPM Dependencies...
call npm install
if %errorlevel% neq 0 (
    echo Error: Failed to install npm dependencies
    pause
    exit /b 1
)

echo.
echo [3/8] Copying Environment File...
if not exist .env (
    copy .env.example .env
    echo Environment file created successfully
) else (
    echo Environment file already exists
)

echo.
echo [4/8] Generating Application Key...
call php artisan key:generate
if %errorlevel% neq 0 (
    echo Error: Failed to generate application key
    pause
    exit /b 1
)

echo.
echo [5/8] Creating Database File...
if not exist database\database.sqlite (
    type nul > database\database.sqlite
    echo SQLite database file created
) else (
    echo SQLite database file already exists
)

echo.
echo [6/8] Running Database Migrations...
call php artisan migrate --force
if %errorlevel% neq 0 (
    echo Error: Failed to run migrations
    pause
    exit /b 1
)

echo.
echo [7/8] Seeding Database...
call php artisan db:seed --force
if %errorlevel% neq 0 (
    echo Error: Failed to seed database
    pause
    exit /b 1
)

echo.
echo [8/9] Building Assets...
call npm run build
if %errorlevel% neq 0 (
    echo Error: Failed to build assets
    pause
    exit /b 1
)

echo.
echo [9/9] Creating Storage Link...
call php artisan storage:link
if %errorlevel% neq 0 (
    echo Warning: Failed to create storage link (may already exist)
)

echo.
echo ========================================
echo    Setup Complete!
echo ========================================
echo.
echo Default Admin Login:
echo Email: admin@example.com
echo Password: adminpassword
echo.
echo To start the development server, run:
echo php artisan serve
echo.
echo Then visit: http://localhost:8000
echo.
pause
