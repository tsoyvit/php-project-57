[![hexlet-check](https://github.com/tsoyvit/php-project-57/actions/workflows/hexlet-check.yml/badge.svg)](https://github.com/tsoyvit/php-project-57/actions/workflows/hexlet-check.yml)
[![Laravel Tests](https://github.com/tsoyvit/php-project-57/actions/workflows/tests.yml/badge.svg)](https://github.com/tsoyvit/php-project-57/actions/workflows/tests.yml)
[![Quality Gate Status](https://sonarcloud.io/api/project_badges/measure?project=tsoyvit_php-project-57&metric=alert_status)](https://sonarcloud.io/summary/new_code?id=tsoyvit_php-project-57)
[![Coverage](https://sonarcloud.io/api/project_badges/measure?project=tsoyvit_php-project-57&metric=coverage)](https://sonarcloud.io/summary/new_code?id=tsoyvit_php-project-57)
[![Security Rating](https://sonarcloud.io/api/project_badges/measure?project=tsoyvit_php-project-57&metric=security_rating)](https://sonarcloud.io/summary/new_code?id=tsoyvit_php-project-57)
[![Maintainability Rating](https://sonarcloud.io/api/project_badges/measure?project=tsoyvit_php-project-57&metric=sqale_rating)](https://sonarcloud.io/summary/new_code?id=tsoyvit_php-project-57)



---
## 📌 Описание

Task Manager — система управления задачами. Она позволяет:
  - создавать задачи с описанием;
  - назначать статусы;
  - назначать исполнителей;
  - регистрировать пользователей и выполнять вход.

---
## 🧩 Особенности реализации
- Разграничение доступа с использованием Policy (удаление задач разрешено только автору)
- Фильтрация, сортировка и пагинация реализованы через Spatie Laravel Query Builder
- Используются Form Request'ы для валидации данных
- Поддержка аутентификации и регистрации через Laravel Breeze
- Реляционные связи моделей:
    - User ↔ Task (HasMany)
    - Task ↔ TaskStatus (BelongsTo)
    - Task ↔ Label (Many-to-Many)
- Настроены CI/CD: GitHub Actions, PHPStan, PHP_CodeSniffer, PHPUnit
- Логирование ошибок через Rollbar
- Покрытие кода модульными тестами (PHPUnit)

---
## ⚙️ Используемые технологии
  - PHP 8.2
  - Laravel 12
  - Laravel Breeze
  - PostgreSQL (в продакшене)
  - SQLite (для локальной разработки)
  - Spatie Laravel Query Builder
  - Spatie Laravel HTML
  - Rollbar
  - Laravel Pint, PHPStan, PHP_CodeSniffer
  - PHPUnit
  - GitHub Actions + SonarCloud — для CI и анализа качества кода

---
## 🚀 Деплой

Приложение задеплоено на Render и доступно по адресу:
🔗 https://php-project-57-sbw7.onrender.com

---
## 📦 Установка и запуск

Системные требования
  - PHP 8.2
  - Composer
  - Node.js 20+
  - npm 10+
  - SQLite (по умолчанию)
  - Make 4.3+

Шаги установки
1. Клонируйте репозиторий:
```bash
git clone https://github.com/tsoyvit/php-project-57.git
cd php-project-57
```
2. Выполните установку зависимостей и настройку проекта:
```bash
make setup
```
3. Запустите встроенный сервер Laravel:
```bash
make start
```
Приложение будет доступно по адресу:
http://localhost:8000

---
## 🧪 Тестирование
Для запуска тестов:

```bash
make test
```
