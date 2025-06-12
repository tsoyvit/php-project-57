#!/bin/bash

# Скрипт для переименования методов тестов test_snake_case -> testCamelCase
# Работает в папке tests/, изменяет файлы на месте

echo "🔍 Поиск и переименование методов тестов..."

find tests/ -type f -name "*.php" | while read file; do
  perl -i -pe '
    # Функция преобразования snake_case в PascalCase (для метода после "test")
    sub pascal {
      my $s = shift;
      $s =~ s/_([a-z])/uc($1)/ge;  # поднимаем каждую букву после _
      $s =~ s/^[a-z]/uc($&)/e;     # первую букву делаем заглавной
      return $s;
    }

    # Найти методы test_something_like_this и заменить на testSomethingLikeThis
    s/(function\s+)test_([a-z0-9_]+)(\s*\()/
      $1 . "test" . pascal($2) . $3
    /eg;
  ' "$file"

  echo "✅ Обработан файл: $file"
done

echo "🎉 Переименование завершено!"
