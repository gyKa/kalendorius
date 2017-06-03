server:
	php -S 0.0.0.0:8080 -t public/

install:
	composer install
	cp .env.example .env
