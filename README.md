# 🚀 InoFa - Innovation Factory

![Laravel](https://img.shields.io/badge/Laravel-12.x-FF2D20?style=for-the-badge&logo=laravel&logoColor=white)
![PHP](https://img.shields.io/badge/PHP-8.2+-777BB4?style=for-the-badge&logo=php&logoColor=white)
![Docker](https://img.shields.io/badge/Docker-Ready-2496ED?style=for-the-badge&logo=docker&logoColor=white)
![TailwindCSS](https://img.shields.io/badge/Tailwind-CSS-38B2AC?style=for-the-badge&logo=tailwind-css&logoColor=white)

**Innovation Factory (InoFa)** adalah platform berbasis web yang mempertemukan konsumen atau perusahaan startup dengan developer. Aplikasi ini memfasilitasi pencarian developer, pembuatan proyek, serta kolaborasi antara kedua pihak.

---

## 📋 Table of Contents

- [Features](#-features)
- [Tech Stack](#-tech-stack)
- [Requirements](#-requirements)
- [Installation](#-installation)
  - [Docker Setup (Recommended)](#-docker-setup-recommended)
  - [Manual Setup](#-manual-setup)
- [Docker Commands](#-docker-commands)
- [Accessing Services](#-accessing-services)
- [Development](#-development)
- [Contributing](#-contributing)

---

## ✨ Features

- 🔍 Pencarian developer berdasarkan skill
- 📝 Manajemen proyek
- 💬 Real-time chat & messaging
- 💰 Sistem pembayaran & escrow
- ⭐ Review & rating
- 🔔 Notifikasi real-time
- 🔐 Autentikasi & otorisasi

---

## 🛠 Tech Stack

| Technology | Description |
|------------|-------------|
| **Laravel 12** | PHP Framework |
| **MySQL 8.0** | Database |
| **Redis** | Caching & Queue |
| **Meilisearch** | Full-text Search Engine |
| **Pusher** | Real-time Broadcasting |
| **TailwindCSS** | CSS Framework |
| **Alpine.js** | JavaScript Framework |
| **Vite** | Frontend Build Tool |

---

## 📦 Requirements

### Untuk Docker Setup
- [Docker Desktop](https://www.docker.com/products/docker-desktop/) (Windows/Mac) atau Docker Engine (Linux)
- Docker Compose v2.x
- Minimal 4GB RAM untuk Docker

### Untuk Manual Setup
- PHP >= 8.2
- Composer
- Node.js >= 20.x
- MySQL >= 8.0
- Redis
- Meilisearch (optional)

---

## 🚀 Installation

### 🐳 Docker Setup (Recommended)

Docker adalah cara termudah untuk menjalankan aplikasi ini. Semua dependencies akan otomatis terinstall.

#### Quick Start (Windows)

```powershell
# Clone repository (jika belum)
git clone <repository-url>
cd inofa-v2

# Jalankan script setup
.\docker-setup.bat
```

#### Manual Docker Setup

1. **Copy file environment:**
   ```bash
   cp .env.docker .env
   ```

2. **Edit file `.env`** dan sesuaikan konfigurasi yang diperlukan (database, Pusher, dll)

3. **Build dan jalankan container:**
   ```bash
   docker-compose build
   docker-compose up -d
   ```

4. **Install dependencies:**
   ```bash
   docker-compose exec app composer install
   docker-compose exec app npm install
   docker-compose exec app npm run build
   ```

5. **Setup Laravel:**
   ```bash
   docker-compose exec app php artisan key:generate
   docker-compose exec app php artisan migrate --seed
   docker-compose exec app php artisan storage:link
   ```

6. **Akses aplikasi di:** http://localhost:8000

---

### 🔐 Default Admin Account

Setelah menjalankan seeder, akun admin default akan tersedia:

| Field | Value |
|-------|-------|
| **Email** | `admin@inofa.com` |
| **Password** | `inofasite` |
| **Role** | Admin |

> ⚠️ **Penting:** Segera ganti password default setelah login pertama kali di production!

---

### 💻 Manual Setup

Jika tidak menggunakan Docker, ikuti langkah berikut:

1. **Clone repository:**
   ```bash
   git clone <repository-url>
   cd inofa-v2
   ```

2. **Install PHP dependencies:**
   ```bash
   composer install
   ```

3. **Install Node.js dependencies:**
   ```bash
   npm install
   ```

4. **Setup environment:**
   ```bash
   cp .env.example .env
   php artisan key:generate
   ```

5. **Konfigurasi database di file `.env`**

6. **Jalankan migrasi:**
   ```bash
   php artisan migrate
   ```

7. **Build assets:**
   ```bash
   npm run build
   ```

8. **Jalankan aplikasi:**
   ```bash
   php artisan serve
   ```

---

## 🐳 Docker Commands

| Command | Description |
|---------|-------------|
| `docker-compose up -d` | Start semua container |
| `docker-compose down` | Stop semua container |
| `docker-compose restart` | Restart semua container |
| `docker-compose logs -f` | Lihat logs (real-time) |
| `docker-compose logs -f app` | Lihat logs container tertentu |
| `docker-compose exec app bash` | Masuk ke shell container app |
| `docker-compose exec app php artisan <command>` | Jalankan Artisan command |
| `docker-compose exec app composer <command>` | Jalankan Composer command |
| `docker-compose exec app npm <command>` | Jalankan NPM command |
| `docker-compose ps` | Lihat status container |

### Common Tasks

```bash
# Jalankan migrasi
docker-compose exec app php artisan migrate

# Fresh migration dengan seeder
docker-compose exec app php artisan migrate:fresh --seed

# Clear cache
docker-compose exec app php artisan cache:clear
docker-compose exec app php artisan config:clear

# Jalankan queue worker
docker-compose exec app php artisan queue:work

# Jalankan tests
docker-compose exec app php artisan test
```

---

## 🌐 Accessing Services

Setelah Docker berjalan, akses layanan berikut:

| Service | URL | Description |
|---------|-----|-------------|
| **Application** | http://localhost:8000 | Laravel Application |
| **Meilisearch** | http://localhost:7700 | Search Engine Dashboard |
| **MySQL** | localhost:3307 | Database (gunakan client seperti DBeaver) |
| **Redis** | localhost:6380 | Cache Server |

---

## 💻 Development

### Menjalankan Development Server dengan Hot Reload

Untuk development dengan Vite hot reload:

```bash
# Jalankan dengan profile dev (termasuk Node container)
docker-compose --profile dev up -d
```

Atau jalankan Vite secara terpisah di dalam container:

```bash
docker-compose exec app npm run dev
```

### Struktur Docker

```
├── Dockerfile              # PHP-FPM image configuration
├── docker-compose.yml      # Services orchestration
├── docker/
│   ├── nginx/
│   │   └── nginx.conf      # Nginx configuration
│   ├── php/
│   │   └── php.ini         # PHP configuration
│   ├── mysql/
│   │   └── my.cnf          # MySQL configuration
│   └── scripts/
│       └── entrypoint.sh   # Container startup script
├── .env.docker             # Docker environment template
└── .dockerignore           # Docker build ignore file
```

### Container Services

| Container | Image | Purpose |
|-----------|-------|---------|
| `inofa-app` | PHP 8.2-FPM (custom) | Laravel application |
| `inofa-nginx` | nginx:alpine | Web server |
| `inofa-mysql` | mysql:8.0 | Database |
| `inofa-redis` | redis:alpine | Cache & session |
| `inofa-meilisearch` | meilisearch:latest | Search engine |
| `inofa-queue` | PHP 8.2-FPM (custom) | Queue worker |
| `inofa-node` | node:20-alpine | Vite dev server (dev profile) |

---

## 🔧 Troubleshooting

### Container tidak bisa start
```bash
# Lihat logs untuk error detail
docker-compose logs -f

# Rebuild container
docker-compose down
docker-compose build --no-cache
docker-compose up -d
```

### Permission denied pada storage
```bash
docker-compose exec app chmod -R 775 storage bootstrap/cache
docker-compose exec app chown -R laravel:www-data storage bootstrap/cache
```

### MySQL connection refused
```bash
# Tunggu MySQL ready (biasanya 15-30 detik setelah start)
docker-compose logs mysql

# Restart MySQL container
docker-compose restart mysql
```

### Reset semua data
```bash
# Stop dan hapus semua container beserta volume
docker-compose down -v

# Start ulang
docker-compose up -d
```

---

## 🤝 Contributing

1. Fork repository
2. Buat feature branch (`git checkout -b feature/AmazingFeature`)
3. Commit changes (`git commit -m 'Add some AmazingFeature'`)
4. Push ke branch (`git push origin feature/AmazingFeature`)
5. Buat Pull Request

---

## 📄 License

Project ini menggunakan lisensi MIT. Lihat file [LICENSE](LICENSE) untuk detail.

---

<p align="center">
  Made with ❤️ by InoFa Team
</p>
