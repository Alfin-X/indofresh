#!/bin/bash

echo "========================================"
echo "    IndoFresh Setup Script"
echo "========================================"
echo

echo "[1/8] Installing Composer Dependencies..."
composer install
if [ $? -ne 0 ]; then
    echo "Error: Failed to install composer dependencies"
    exit 1
fi

echo
echo "[2/8] Installing NPM Dependencies..."
npm install
if [ $? -ne 0 ]; then
    echo "Error: Failed to install npm dependencies"
    exit 1
fi

echo
echo "[3/8] Copying Environment File..."
if [ ! -f .env ]; then
    cp .env.example .env
    echo "Environment file created successfully"
else
    echo "Environment file already exists"
fi

echo
echo "[4/8] Generating Application Key..."
php artisan key:generate
if [ $? -ne 0 ]; then
    echo "Error: Failed to generate application key"
    exit 1
fi

echo
echo "[5/8] Creating Database File..."
if [ ! -f database/database.sqlite ]; then
    touch database/database.sqlite
    echo "SQLite database file created"
else
    echo "SQLite database file already exists"
fi

echo
echo "[6/8] Running Database Migrations..."
php artisan migrate --force
if [ $? -ne 0 ]; then
    echo "Error: Failed to run migrations"
    exit 1
fi

echo
echo "[7/8] Seeding Database..."
php artisan db:seed --force
if [ $? -ne 0 ]; then
    echo "Error: Failed to seed database"
    exit 1
fi

echo
echo "[8/9] Building Assets..."
npm run build
if [ $? -ne 0 ]; then
    echo "Error: Failed to build assets"
    exit 1
fi

echo
echo "[9/9] Creating Storage Link..."
php artisan storage:link
if [ $? -ne 0 ]; then
    echo "Warning: Failed to create storage link (may already exist)"
fi

echo
echo "========================================"
echo "    Setup Complete!"
echo "========================================"
echo
echo "Default Admin Login:"
echo "Email: admin@example.com"
echo "Password: adminpassword"
echo
echo "To start the development server, run:"
echo "php artisan serve"
echo
echo "Then visit: http://localhost:8000"
echo
