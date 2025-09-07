Предварительные требования
Docker Desktop (Windows/Mac) или Docker Engine (Linux)
Git
4 ГБ+ оперативной памяти
1. Клонирование репозитория
git clone https://github.com/Fotonchik/laravel_test.git
cd laravel_test
git checkout main-new

2. Запуск проекта
bash
3. Запуск всех контейнеров

docker compose up -d --build

4. Копируем пример файла окружения

cp .env.example .env
docker compose exec app php artisan key:generate

5. Установите зависимости Composer внутри контейнера
bash

docker compose exec app composer install
