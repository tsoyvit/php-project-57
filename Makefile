setup:
	composer install
	@if [ ! -f .env ]; then cp .env.example .env; fi
	php artisan key:generate
	touch database/database.sqlite
	php artisan migrate --seed
	npm ci
	npm run build

start:
	php artisan serve --host=0.0.0.0 --port=8000

test:
	./vendor/bin/phpunit

stan:
	./vendor/bin/phpstan analyse

stan-clear:
	./vendor/bin/phpstan clear-result-cache

lint:
	vendor/bin/phpcs

fix:
	vendor/bin/phpcbf

pint:
	vendor/bin/pint

migrate:
	php artisan migrate

seed:
	php artisan db:seed

d:
	composer dump-autoload
