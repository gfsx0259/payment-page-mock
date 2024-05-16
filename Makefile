#!/usr/bin/make

install: pull env deploy composer migrate

pull:
	docker image pull konstantinpopov/dummy-fpm:latest
	docker image pull konstantinpopov/dummy-spa:latest

env:
ifeq (,$(wildcard .env))
	cp .env.example .env
endif

deploy:
	docker compose up -d

exec:
	docker compose exec dummy-fpm bash

composer:
	docker compose exec dummy-fpm composer i

migrate:
	docker compose exec dummy-fpm ./yii migrate/up -q
	docker compose exec dummy-fpm ./yii fixture/load

test:
	docker compose exec dummy-fpm composer test


