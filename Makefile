.DEFAULT_GOAL := help
.PHONY: help
help:
	@grep -E '^[a-zA-Z_-]+:.*?## .*$$' $(MAKEFILE_LIST) | sort | awk 'BEGIN {FS = ":.*?## "}; {printf "\033[36m%-15s\033[0m %s\n", $$1, $$2}'
	@echo
	@printf %b "To run all the puzzles, use the command:      \033[36mphp src/main.php\033[0m\n"
	@printf %b "To run an individual puzzle, use the command: \033[36mphp src/main.php 01\033[0m\n"
	@printf %b "To run a benchmark, add the flag \033[36m-b\033[0m:          \033[36mphp src/main.php 01 -b\033[0m\n"

.PHONY: docker-build
docker-build: ## Builds the docker image with PHP, Composer, and Xdebug
	docker build -t aoc-2023 -f docker/aoc-2023.Dockerfile .

.PHONY: shell
shell: ## Starts an interactive shell with PHP in Docker
	docker run --rm --interactive --tty --volume $(PWD):/app aoc-2023 /bin/bash

.PHONY: lint
lint: ## Runs linters and static-analysis
	vendor/bin/phpcs -p --standard=PSR12 src/ tests/
	vendor/bin/psalm --show-info=true

.PHONY: run
run: ## Runs all puzzle solutions
	php src/main.php

.PHONY: run-benchmark
run-benchmark: ## Calculates average run-time for all puzzle solutions
	php src/main.php -b

.PHONY: test
test: ## Runs all unit tests with PHPUnit and Testdox
	./vendor/bin/phpunit --testdox --colors tests
