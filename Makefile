#!/usr/bin/make
include .env
export

STACK_NAME := dummy
STACK_CONFIG := docker-compose.prod.yml

install: pull deploy

pull:
	sudo docker image pull konstantinpopov/dummy-api:main
	sudo docker image pull konstantinpopov/dummy-fpm:main
	sudo docker image pull konstantinpopov/dummy-spa:main

deploy:
	envsubst < $(STACK_CONFIG) | sudo docker stack deploy -c - $(STACK_NAME)

clear:
	sudo docker stack rm $(STACK_NAME)

status:
	sudo docker stack services $(STACK_NAME)

utils_deps:
	docker-compose exec dummy-fpm composer install

load:
	docker compose exec dummy-fpm ./yii migrate/up -q
	docker compose exec dummy-fpm ./yii fixture/load
	docker compose cp ./src/server/public/uploads/route dummy-fpm:/var/www/public/uploads

sync_image:
	docker compose cp dummy-fpm:/var/www/public/uploads/route ./src/server/public/uploads

utils_test:
	docker-compose exec dummy-fpm composer test
