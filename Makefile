#!/usr/bin/make
include .env
export

CURRENT_DIR := $(shell pwd)
STACK_NAME := dummy
STACK_CONFIG := docker-compose.prod.yml
GITHUB_RAW := https://raw.githubusercontent.com/gfsx0259/payment-page-mock/main

RUNTIME_DIR := runtime
PUBLIC_DIR := src/server/public
SHARED_DIRS := $(RUNTIME_DIR)/assets $(RUNTIME_DIR)/uploads
ROUTE_IMAGES := card gcash kakaopay pix neofinance googlepay
APP_TABLES := route callback stub resource

install: prepare pull deploy
utils_example: utils_db_load utils_images_load_dev

prepare:
	sudo mkdir -p $(SHARED_DIRS)
	sudo chown -R 1000:1000 runtime

pull:
	sudo docker image pull konstantinpopov/dummy-api:main
	sudo docker image pull konstantinpopov/dummy-fpm:main
	sudo docker image pull konstantinpopov/dummy-spa:main

deploy:
	envsubst < $(STACK_CONFIG) | sudo docker stack deploy -c - $(STACK_NAME)

clear:
	sudo docker stack rm $(STACK_NAME)
	sudo rm -rf $(SHARED_DIRS)

status:
	sudo docker stack services $(STACK_NAME)

utils_db_clear:
	sudo docker volume rm $(STACK_NAME)_dbdata

utils_db_load:
	curl $(GITHUB_RAW)/build/example/dump/app.sql > runtime/app.sql
	$(eval CONTAINER_ID=$(shell sudo docker ps -q -f name="db"))
	sudo docker exec -i $(CONTAINER_ID) mysql -uuser -ppassword app < runtime/app.sql

utils_db_dump:
	docker-compose exec db bash -c "mysqldump --no-tablespaces -proot app $(APP_TABLES) -r "/docker-entrypoint-initdb.d/app.sql""

utils_images_load_dev:
	mkdir -p $(CURRENT_DIR)/$(PUBLIC_DIR)/uploads/route
	$(foreach ROUTE_IMAGE, $(ROUTE_IMAGES), \
		cd $(CURRENT_DIR)/$(PUBLIC_DIR)/uploads/route && curl -O $(GITHUB_RAW)/build/example/images/$(ROUTE_IMAGE).svg; \
  	)

utils_images_load_prod:
	mkdir -p $(CURRENT_DIR)/$(RUNTIME_DIR)/uploads/route
	$(foreach ROUTE_IMAGE, $(ROUTE_IMAGES), \
		cd $(CURRENT_DIR)/$(RUNTIME_DIR)/uploads/route && curl -O $(GITHUB_RAW)/build/example/images/$(ROUTE_IMAGE).svg; \
  	)

utils_deps:
	docker-compose exec dummy-fpm composer install

utils_test:
	docker-compose exec dummy-fpm composer test
