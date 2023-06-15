SHELL := bash

dcr = docker compose run --rm php
composer = $(dcr) composer

.PHONY: install
install: .env
	@$(composer) install

.env:
	@$(dcr) cp .env.example .env

.PHONY: clean
clean:
	@$(dcr) rm -rf ./.phpunit.result.cache
	@$(dcr) rm -rf ./vendor

.PHONY: phpcbf
phpcbf:
	@$(composer) phpcbf

.PHONY: phpcs
phpcs:
	@$(composer) phpcs

.PHONY: phpstan
phpstan:
	@$(composer) phpstan

.PHONY: phpunit
phpunit:
	@$(composer) phpunit

.PHONY: rector
rector:
	@$(composer) rector

.PHONY: phpcbf
ci:
	@$(composer) ci
