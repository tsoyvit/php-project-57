FROM php:8.2-cli

# Установка зависимостей PHP
RUN apt-get update && apt-get install -y \
    libpq-dev \
    libzip-dev \
    && docker-php-ext-install pdo pdo_pgsql zip

# Установка Composer
RUN php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');" \
    && php composer-setup.php --install-dir=/usr/local/bin --filename=composer \
    && php -r "unlink('composer-setup.php');"

# Установка Node.js 20.x и npm
RUN curl -sL https://deb.nodesource.com/setup_20.x | bash - \
    && apt-get install -y nodejs

WORKDIR /app

# Копирование файлов проекта
COPY . .

# Установка PHP-зависимостей
RUN composer install --no-dev --optimize-autoloader

# Установка npm-зависимостей (включая devDependencies)
RUN npm ci --include=dev

# Сборка статики (Vite)
RUN npm run build \
    && chmod -R 775 /app/public/build  # Права на запись

# Запуск миграций и сервера
CMD ["bash", "-c", "php artisan migrate --force && php artisan serve --host=0.0.0.0 --port=$PORT"]
