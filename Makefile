IMAGE_NAME ?= ci-cd-blueprint
APP_PORT   ?= 8080

.DEFAULT_GOAL := help
.PHONY: help install lint fix analyse test check build up down restart logs health shell scan clean

help: ## Show this help
	@grep -hE '^[a-zA-Z_-]+:.*?## ' $(MAKEFILE_LIST) \
		| awk 'BEGIN {FS = ":.*?## "}; {printf "  [36m%-10s[0m %s
", $$1, $$2}'

install: ## Install PHP dependencies
	composer install

lint: ## Check formatting without changing files
	composer run lint

fix: ## Rewrite files to match the style rules
	composer run fix

analyse: ## Run PHPStan at level 9
	composer run analyse

test: ## Run the test suite
	composer run test

check: lint analyse test ## Run everything CI runs

build: ## Build the runtime image
	docker build --target runtime -t $(IMAGE_NAME):local .

up: ## Build and start the stack
	APP_PORT=$(APP_PORT) docker compose up --build --detach
	@echo "Listening on http://localhost:$(APP_PORT)"

down: ## Stop the stack
	docker compose down --remove-orphans

restart: down up ## Recreate the stack

logs: ## Follow container logs
	docker compose logs --follow app

health: ## Curl the health endpoint
	curl --fail --silent http://localhost:$(APP_PORT)/health && echo

shell: ## Open a shell in the running container
	docker compose exec app bash

scan: build ## Scan the built image for fixable high or critical CVEs
	docker run --rm --volume /var/run/docker.sock:/var/run/docker.sock \
		aquasec/trivy:0.58.1 image --scanners vuln --severity HIGH,CRITICAL \
		--ignore-unfixed --exit-code 1 $(IMAGE_NAME):local

clean: ## Stop the stack and remove volumes
	docker compose down --remove-orphans --volumes
