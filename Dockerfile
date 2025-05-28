# Используем образ с веб-сервером
FROM php:8.2-apache

# Установка зависимостей
RUN apt-get update && apt-get install -y \
    libpq-dev \
    libzip-dev \
    zip \
    && docker-php-ext-install pdo pdo_pgsql zip \
    && apt-get clean

# Установка Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Установка Node.js (только если фронтенд нужен)
RUN curl -fsSL https://deb.nodesource.com/setup_20.x | bash - \
    && apt-get install -y nodejs \
    && npm install -g npm

# 1. Копируем только файлы для установки зависимостей
COPY composer.json composer.lock package.json package-lock.json* ./

# 2. Установка зависимостей (с кешированием)
RUN composer install --no-dev --no-scripts --no-autoloader \
    && ([ -f package-lock.json ] && npm ci || echo "No package-lock.json, skipping npm") \
    && composer clear-cache

# 3. Копируем весь проект
WORKDIR /var/www/html
COPY . .

# 4. Оптимизация Laravel и сборка фронтенда
RUN composer dump-autoload --optimize \
    && php artisan config:cache \
    && php artisan route:cache \
    && php artisan view:cache \
    && ([ -f package-lock.json ] && npm run build || echo "No frontend build required") \
    && chmod -R 775 storage bootstrap/cache

# Настройка Apache
RUN a2enmod rewrite \
    && sed -i 's!/var/www/html!/var/www/html/public!g' /etc/apache2/sites-available/000-default.conf \
    && sed -i '/<Directory \/var\/www\/>/,/<\/Directory>/ s/AllowOverride None/AllowOverride All/' /etc/apache2/apache2.conf

# Запуск миграций и сервера
CMD ["bash", "-c", "php artisan migrate --force && apache2-foreground"]
