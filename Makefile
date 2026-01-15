# Makefile for Docker Laravel Project

.PHONY: help build up down restart logs shell mysql redis artisan composer npm fresh migrate seed test

# Default target
help:
	@echo "Available commands:"
	@echo "  make build      - Build Docker images"
	@echo "  make up         - Start all containers"
	@echo "  make up-dev     - Start all containers including Node for Vite"
	@echo "  make down       - Stop all containers"
	@echo "  make restart    - Restart all containers"
	@echo "  make logs       - View container logs"
	@echo "  make shell      - Access app container shell"
	@echo "  make mysql      - Access MySQL CLI"
	@echo "  make redis      - Access Redis CLI"
	@echo "  make artisan    - Run artisan command (use: make artisan cmd='migrate')"
	@echo "  make composer   - Run composer command (use: make composer cmd='install')"
	@echo "  make npm        - Run npm command (use: make npm cmd='install')"
	@echo "  make fresh      - Fresh install (migrate:fresh + seed)"
	@echo "  make migrate    - Run database migrations"
	@echo "  make seed       - Run database seeders"
	@echo "  make test       - Run PHPUnit tests"
	@echo "  make setup      - Initial project setup"

# Build Docker images
build:
	docker-compose build

# Start containers
up:
	docker-compose up -d

# Start containers with dev profile (includes Node for Vite)
up-dev:
	docker-compose --profile dev up -d

# Stop containers
down:
	docker-compose down

# Restart containers
restart:
	docker-compose restart

# View logs
logs:
	docker-compose logs -f

# Access app container shell
shell:
	docker-compose exec app bash

# Access MySQL CLI
mysql:
	docker-compose exec mysql mysql -u inofa -psecret inofa

# Access Redis CLI
redis:
	docker-compose exec redis redis-cli

# Run artisan command
artisan:
	docker-compose exec app php artisan $(cmd)

# Run composer command
composer:
	docker-compose exec app composer $(cmd)

# Run npm command
npm:
	docker-compose exec app npm $(cmd)

# Fresh database
fresh:
	docker-compose exec app php artisan migrate:fresh --seed

# Run migrations
migrate:
	docker-compose exec app php artisan migrate

# Run seeders
seed:
	docker-compose exec app php artisan db:seed

# Run tests
test:
	docker-compose exec app php artisan test

# Initial setup
setup:
	@echo "🚀 Starting initial setup..."
	@cp -n .env.docker .env || true
	docker-compose build
	docker-compose up -d
	@echo "⏳ Waiting for containers to be ready..."
	@sleep 10
	docker-compose exec app composer install
	docker-compose exec app php artisan key:generate
	docker-compose exec app php artisan migrate
	docker-compose exec app php artisan storage:link
	docker-compose exec app npm install
	docker-compose exec app npm run build
	@echo "✅ Setup complete! Access the application at http://localhost:8000"
