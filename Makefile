SHELL := /bin/bash

.PHONY: init
init: ## Copies env file if does not exists and sets githooks

.PHONY: setup
setup: init up

.PHONY: up
up: ## Force recreate and start of local containers
	docker compose down --remove-orphans -v
	docker compose pull
	docker compose up -d --force-recreate
