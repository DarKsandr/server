# О проекте
Доамашний сервер для "Домовёнок Кузя"

# Установка
Первоначальная установка composer:
```
docker run --rm \
-u "$(id -u):$(id -g)" \
-v "$(pwd):/var/www/html" \
-w /var/www/html \
laravelsail/php84-composer:latest \
composer install --ignore-platform-reqs
```

Загрузка обновлений на сервер:
```
git fetch && git reset --hard origin/main
```

# Запуск
```
./vendor/bin/sail up -d
```

# Старт на сервере
```
./vendor/bin/sail -f docker-compose-server.yml up -d
```
