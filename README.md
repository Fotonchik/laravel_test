Предварительные требования
Docker Desktop (Windows/Mac) или Docker Engine (Linux)
Git
4 ГБ+ оперативной памяти
1. Клонирование репозитория
   
```
git clone https://github.com/Fotonchik/laravel_test.git

cd laravel_test

git checkout main-new

```

3. Запуск проекта
bash
4. Запуск всех контейнеров

```
docker compose up -d --build

```

5. Копируем пример файла окружения
   
```
cp .env.example .env

```

6. Вставить в  .env
```
DB_CONNECTION=mysql
DB_HOST=db
DB_PORT=3306
DB_DATABASE=laravel
DB_USERNAME=root
DB_PASSWORD=secret
```
7. Установите зависимости Composer внутри контейнера
bash

```

docker compose exec app composer install

docker compose exec app php artisan key:generate

sudo chmod -R  777 ./

```

