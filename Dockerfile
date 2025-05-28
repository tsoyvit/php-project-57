FROM php:8.2-cli

RUN apt-get update && apt-get install -y \
    libpq-dev \
    libzip-dev \
    unzip \
    curl \
    git \
    nodejs \
    npm

RUN docker-php-ext-install pdo pdo_pgsql zip

# Установка Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Рабочая директория
WORKDIR /app

# Копируем файлы
COPY . .

# Установка PHP-зависимостей
RUN composer install

# Установка и сборка фронтенда
RUN npm ci && npm run build

# Выполняем миграции и запускаем сервер
CMD php artisan migrate --force && php -S 0.0.0.0:$PORT -t public
