#!/usr/bin/make

install: pull env deploy

pull:
	docker image pull konstantinpopov/dummy-fpm:main
	docker image pull konstantinpopov/dummy-spa:main

env:
ifeq (,$(wildcard .env))
	cp .env.example .env
endif

deploy:
	docker-compose up -d

exec:
	docker-compose exec dummy-fpm bash

composer:
	docker-compose exec dummy-fpm composer i

migrate:
	docker compose exec dummy-fpm ./yii migrate/up -q
	docker compose exec dummy-fpm ./yii fixture/load

test:
	docker-compose exec dummy-fpm composer test


