test:
	vendor/bin/phpunit

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

serve:
	php artisan serve

d:
	composer dump-autoload

