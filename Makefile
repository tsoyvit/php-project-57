.PHONY: setup start test test-coverage stan stan-clear lint fix pint migrate seed dump ci

## Project setup
setup:
	composer install
	@if [ ! -f .env ]; then cp .env.example .env; fi
	php artisan key:generate
	touch database/database.sqlite
	php artisan migrate --seed
	npm ci
	npm run build

## Start development server
start:
	php artisan serve --host=0.0.0.0 --port=8000

## Testing
test:
	./vendor/bin/phpunit

test-coverage:
	mkdir -p reports
	./vendor/bin/phpunit --coverage-clover=reports/coverage.xml

## Static analysis
stan:
	./vendor/bin/phpstan analyse --memory-limit=2G

stan-clear:
	./vendor/bin/phpstan clear-result-cache

## Code style
lint:
	vendor/bin/phpcs

fix:
	vendor/bin/phpcbf

pint:
	vendor/bin/pint

## Database
migrate:
	php artisan migrate

seed:
	php artisan db:seed

## Composer
dump:
	composer dump-autoload

## CI Pipeline (for GitHub Actions)
ci: setup test lint test-coverage stan
