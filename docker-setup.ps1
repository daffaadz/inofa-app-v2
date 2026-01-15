# Docker Setup Script for Windows PowerShell
# Run this script to setup the Laravel application with Docker

Write-Host "🚀 Starting Laravel Docker Setup..." -ForegroundColor Cyan

# Check if Docker is running
try {
    docker info | Out-Null
    Write-Host "✅ Docker is running" -ForegroundColor Green
} catch {
    Write-Host "❌ Docker is not running. Please start Docker Desktop first." -ForegroundColor Red
    exit 1
}

# Copy .env.docker to .env if .env doesn't exist
if (-not (Test-Path ".env")) {
    Write-Host "📝 Creating .env file from .env.docker..." -ForegroundColor Yellow
    Copy-Item ".env.docker" ".env"
    Write-Host "✅ .env file created" -ForegroundColor Green
} else {
    Write-Host "ℹ️ .env file already exists, skipping..." -ForegroundColor Blue
}

# Build Docker images
Write-Host "`n📦 Building Docker images..." -ForegroundColor Yellow
docker-compose build

# Start containers
Write-Host "`n🚀 Starting Docker containers..." -ForegroundColor Yellow
docker-compose up -d

# Wait for MySQL to be ready
Write-Host "`n⏳ Waiting for MySQL to be ready..." -ForegroundColor Yellow
$maxAttempts = 30
$attempt = 0
do {
    $attempt++
    Start-Sleep -Seconds 2
    $result = docker-compose exec -T mysql mysqladmin ping -h localhost -u root -psecret 2>$null
    if ($LASTEXITCODE -eq 0) {
        Write-Host "✅ MySQL is ready!" -ForegroundColor Green
        break
    }
    Write-Host "  Attempt $attempt of $maxAttempts..." -ForegroundColor Gray
} while ($attempt -lt $maxAttempts)

if ($attempt -ge $maxAttempts) {
    Write-Host "❌ MySQL failed to start. Please check the logs." -ForegroundColor Red
    docker-compose logs mysql
    exit 1
}

# Install Composer dependencies
Write-Host "`n📦 Installing Composer dependencies..." -ForegroundColor Yellow
docker-compose exec app composer install --no-interaction --prefer-dist --optimize-autoloader

# Generate application key
Write-Host "`n🔑 Generating application key..." -ForegroundColor Yellow
docker-compose exec app php artisan key:generate --force

# Run migrations
Write-Host "`n🗄️ Running database migrations..." -ForegroundColor Yellow
docker-compose exec app php artisan migrate --force

# Run seeders (create admin user)
Write-Host "`n🌱 Running database seeders..." -ForegroundColor Yellow
docker-compose exec app php artisan db:seed --force

# Create storage link
Write-Host "`n🔗 Creating storage link..." -ForegroundColor Yellow
docker-compose exec app php artisan storage:link --force

# Install NPM dependencies and build assets
Write-Host "`n📦 Installing NPM dependencies..." -ForegroundColor Yellow
docker-compose exec app npm install

Write-Host "`n🔨 Building frontend assets..." -ForegroundColor Yellow
docker-compose exec app npm run build

# Clear caches
Write-Host "`n🧹 Clearing caches..." -ForegroundColor Yellow
docker-compose exec app php artisan config:clear
docker-compose exec app php artisan cache:clear
docker-compose exec app php artisan route:clear
docker-compose exec app php artisan view:clear

Write-Host "`n" -NoNewline
Write-Host "========================================" -ForegroundColor Green
Write-Host "  ✅ Setup Complete!" -ForegroundColor Green
Write-Host "========================================" -ForegroundColor Green
Write-Host "`nAccess your application at:" -ForegroundColor Cyan
Write-Host "  🌐 Application: http://localhost:8000" -ForegroundColor White
Write-Host "  📊 Meilisearch: http://localhost:7700" -ForegroundColor White
Write-Host "`nUseful Docker commands:" -ForegroundColor Cyan
Write-Host "  docker-compose logs -f          # View logs" -ForegroundColor Gray
Write-Host "  docker-compose exec app bash    # Access app shell" -ForegroundColor Gray
Write-Host "  docker-compose down             # Stop containers" -ForegroundColor Gray
Write-Host "  docker-compose up -d            # Start containers" -ForegroundColor Gray
Write-Host "`n"
