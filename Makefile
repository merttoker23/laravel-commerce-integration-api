up:
	docker compose up -d --build

install:
	docker compose exec app composer install
	docker compose exec app php artisan key:generate
	docker compose exec app php artisan migrate --seed

test:
	docker compose exec app php artisan test

logs:
	docker compose logs -f
