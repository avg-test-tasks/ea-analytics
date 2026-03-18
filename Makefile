.PHONY: setup
setup:
	php artisan cache:clear
	php artisan migrate:fresh

.PHONY: fetch
fetch: setup
	php artisan app:fetch:order
	php artisan app:fetch:sales
