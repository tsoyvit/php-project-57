test:
	vendor/bin/phpunit

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

refresh-all:
	php artisan migrate:fresh --seed

seed-task-statuses:
	php artisan db:seed --class=TaskStatusSeeder

serve:
	php artisan serve

d:
	composer dump-autoload

