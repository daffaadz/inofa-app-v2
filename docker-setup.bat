@echo off
REM Docker Setup Script for Windows CMD
REM Run this script to setup the Laravel application with Docker

echo.
echo ========================================
echo   Laravel Docker Setup
echo ========================================
echo.

REM Check if Docker is running
docker info >nul 2>&1
if %errorlevel% neq 0 (
    echo [ERROR] Docker is not running. Please start Docker Desktop first.
    pause
    exit /b 1
)
echo [OK] Docker is running

REM Copy .env.docker to .env if .env doesn't exist
if not exist ".env" (
    echo [INFO] Creating .env file from .env.docker...
    copy ".env.docker" ".env"
    echo [OK] .env file created
) else (
    echo [INFO] .env file already exists, skipping...
)

REM Build Docker images
echo.
echo [INFO] Building Docker images...
docker-compose build
if %errorlevel% neq 0 (
    echo [ERROR] Failed to build Docker images
    pause
    exit /b 1
)

REM Start containers
echo.
echo [INFO] Starting Docker containers...
docker-compose up -d
if %errorlevel% neq 0 (
    echo [ERROR] Failed to start Docker containers
    pause
    exit /b 1
)

REM Wait for MySQL
echo.
echo [INFO] Waiting for MySQL to be ready (this may take a moment)...
timeout /t 15 /nobreak >nul

REM Install Composer dependencies
echo.
echo [INFO] Installing Composer dependencies...
docker-compose exec app composer install --no-interaction --prefer-dist --optimize-autoloader

REM Generate application key
echo.
echo [INFO] Generating application key...
docker-compose exec app php artisan key:generate --force

REM Run migrations
echo.
echo [INFO] Running database migrations...
docker-compose exec app php artisan migrate --force

REM Run seeders (create admin user)
echo.
echo [INFO] Running database seeders...
docker-compose exec app php artisan db:seed --force

REM Create storage link
echo.
echo [INFO] Creating storage link...
docker-compose exec app php artisan storage:link --force

REM Install NPM dependencies
echo.
echo [INFO] Installing NPM dependencies...
docker-compose exec app npm install

REM Build frontend assets
echo.
echo [INFO] Building frontend assets...
docker-compose exec app npm run build

REM Clear caches
echo.
echo [INFO] Clearing caches...
docker-compose exec app php artisan config:clear
docker-compose exec app php artisan cache:clear

echo.
echo ========================================
echo   Setup Complete!
echo ========================================
echo.
echo Access your application at:
echo   Application: http://localhost:8000
echo   Meilisearch: http://localhost:7700
echo.
echo Useful Docker commands:
echo   docker-compose logs -f          - View logs
echo   docker-compose exec app bash    - Access app shell
echo   docker-compose down             - Stop containers
echo   docker-compose up -d            - Start containers
echo.
pause
