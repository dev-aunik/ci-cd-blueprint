IMAGE_NAME ?= devmehedi/ci-cd-blueprint
APP_PORT ?= 8080

.PHONY: build up down logs lint clean

build:
	docker build -t $(IMAGE_NAME):latest .

up:
	APP_PORT=$(APP_PORT) docker compose up --build

down:
	docker compose down --remove-orphans

logs:
	docker compose logs -f app

lint:
	docker run --rm -v "$(PWD)/src:/app:ro" -w /app php:8.3-cli sh -c 'find . -name "*.php" -print -exec php -l {} \;'

clean:
	docker compose down --remove-orphans --volumes
