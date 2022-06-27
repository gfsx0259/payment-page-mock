# Bash
repositoryRaw := https://raw.githubusercontent.com/gfsx0259/payment-page-mock/main
uploadImagesDir := src/server/public/uploads/route

install: prepare pull deploy

prepare:
	sudo mkdir -p assets uploads
	sudo chown -R 1000:1000 assets
	sudo chown -R 1000:1000 uploads

pull:
	sudo docker image pull konstantinpopov/payment-page-mock-api:main
	sudo docker image pull konstantinpopov/payment-page-mock-nginx:main
	sudo docker image pull konstantinpopov/payment-page-mock-client:main

deploy:
	sudo docker stack deploy -c docker-compose.prod.yml dummy

clear:
	sudo docker stack rm dummy
	sudo rm -rf assets
	sudo rm -rf uploads

status:
	sudo docker stack services dummy

storage_clear:
	sudo docker volume rm dummy_dbdata

storage_load:
	curl -s -O $(repositoryRaw)/build/dump/app.sql
	$(eval CONTAINER_ID=$(shell sudo docker ps -q -f name="db"))
	sudo docker exec -i $(CONTAINER_ID) mysql -uuser -ppassword app < ./app.sql

storage_dump:
	docker-compose exec db bash -c "mysqldump --no-tablespaces -proot app route callback stub -r "/docker-entrypoint-initdb.d/app.sql""

image_load:
	cd $(uploadImagesDir) && curl -O $(repositoryRaw)/build/example/card.svg
	cd $(uploadImagesDir) && curl -O $(repositoryRaw)/build/example/gcash.svg
	cd $(uploadImagesDir) && curl -O $(repositoryRaw)/build/example/kakaopay.svg
	cd $(uploadImagesDir) && curl -O $(repositoryRaw)/build/example/pix.svg

deps:
	docker-compose exec api composer install

test:
	docker-compose exec api bash -c "composer test"

example: storage_load image_load
