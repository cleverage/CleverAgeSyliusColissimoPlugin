dc := docker-compose
de := $(dc) exec
sy := $(de) php php bin/console

.DEFAULT_GOAL := help
.PHONY: help
help:
	@grep -E '^[a-zA-Z_-]+:.*?## .*$$' $(MAKEFILE_LIST) | sort | awk 'BEGIN {FS = ":.*?## "}; {printf "\033[36m%-30s\033[0m %s\n", $$1, $$2}'

.PHONY: install
install: ## Install the different dependencies (docker-compose up must be started)
	$(de) php composer install

.PHONY: build
build: ## Create docker containers
	$(dc) build

.PHONY: dev
dev: ## Launch the development environment
	$(dc) up -d

.PHONY: mysql
mysql: ## Allows you to enter the mysql container
	$(de) mysql bash

.PHONY: stop
stop: ## Stop les container docker
	$(dc) stop

.PHONY: seed
seed: vendor/autoload.php ## Generate data in the database (docker-compose up must be started)
	$(sy) doctrine:database:create --if-not-exists
	$(sy) doctrine:schema:drop -f
	$(sy) doctrine:schema:update -f

.PHONY: cc
cc: vendor/autoload.php ## Clear cache
	$(sy) cache:clear
