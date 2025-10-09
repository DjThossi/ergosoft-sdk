.DEFAULT_GOAL:=help
DOCKER_COMPOSE_SERVICE_NAME=php

.PHONY: help
help:
	@grep -E '^[\.0-9a-zA-Z_-]+:.*?## .*$$' Makefile | sort | awk 'BEGIN {FS = ":.*?## "}; {printf "\033[36m%-30s\033[0m %s\n", $$1, $$2}'

.PHONY: setup
setup: remove-composer-lock phpLatest-composer-update ## Setup project and dependencies

.PHONY: remove-composer-lock
remove-composer-lock: ## Setup project and dependencies
	rm -f composer.lock | true

.PHONY: all-test-fast
all-test-fast: remove-composer-lock phpLatest-composer-update phpLatest-test-fast ## Runs composer-update and test-fast for each configured php version

.PHONY: php-cs-fix
php-cs-fix: ## Run Composer install
	docker compose run --rm php sh -c "vendor/bin/php-cs-fixer fix"


#PHP Latest Section. Latest means latest available on https://github.com/sineverba/php8xc
.PHONY: phpLatest-composer-install
phpLatest-composer-install: ## Run Composer install with PHP version Latest
	docker compose run --rm php sh -c "composer install"

.PHONY: phpLatest-composer-update
phpLatest-composer-update: ## Run Composer update with PHP version Latest
	docker compose run --rm php sh -c "composer update"

.PHONY: phpLatest-test-fast
phpLatest-test-fast: ## Run phpunit without coverage with PHP version Latest
	docker compose run --rm php sh -c "vendor/bin/phpunit --no-coverage"

.PHONY: phpLatest-test
phpLatest-test: ## Run phpunit with coverage with PHP version Latest
	docker compose run --rm php sh -c "vendor/bin/phpunit"

.PHONY: examples-deleteJob
examples-deleteJob: ## Runs the example code for the delete-job API in the PHP version which is defined in DOCKER_COMPOSE_SERVICE_NAME
	docker compose run --rm ${DOCKER_COMPOSE_SERVICE_NAME} php examples/delete-job.php

.PHONY: examples-getJobs
examples-getJobs: ## Runs the example code for the get-jobs API in the PHP version which is defined in DOCKER_COMPOSE_SERVICE_NAME
	docker compose run --rm ${DOCKER_COMPOSE_SERVICE_NAME} php examples/get-jobs.php

.PHONY: examples-getJobByGuid
examples-getJobByGuid: ## Runs the example code for the get-job-by-guid API in the PHP version which is defined in DOCKER_COMPOSE_SERVICE_NAME
	docker compose run --rm ${DOCKER_COMPOSE_SERVICE_NAME} php examples/get-job-by-guid.php

.PHONY: examples-submitDeltaXmlFile
examples-submitDeltaXmlFile: ## Runs the example code for the submit-delta-xml-file API in the PHP version which is defined in DOCKER_COMPOSE_SERVICE_NAME
	docker compose run --rm ${DOCKER_COMPOSE_SERVICE_NAME} php examples/submit-delta-xml-file.php
