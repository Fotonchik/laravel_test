# Laravel Project with Docker

Проект интернет-магазина на Laravel с Docker-контейнеризацией.

## 🚀 Быстрый запуск

### Предварительные требования
- Docker Desktop (Windows/Mac) или Docker Engine (Linux)
- Git
- 4 ГБ+ оперативной памяти

### 1. Клонирование репозитория
```bash
git clone https://github.com/Fotonchik/laravel_test.git
cd laravel_test
git checkout main-new
**2. Запуск проекта**
bash
**# Запуск всех контейнеров**
docker compose up -d --build
docker compose exec app php artisan key:generate
**
3. Установите зависимости Composer внутри контейнера**
bash
docker compose exec app composer install
