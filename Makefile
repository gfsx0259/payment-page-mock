# Bash
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

storage_clear:
	sudo docker volume rm dummy_dbdata

storage_load:
	curl -s -O https://raw.githubusercontent.com/gfsx0259/payment-page-mock/main/build/dump/app.sql
	$(eval CONTAINER_ID=$(shell sudo docker ps -q -f name="db"))
	sudo docker exec -i $(CONTAINER_ID) mysql -uuser -ppassword app < ./app.sql

listen_queues:
	$(eval CONTAINER_ID=$(shell sudo docker ps -q -f name="api"))
	sudo docker exec -i $(CONTAINER_ID) php yii queue/listen-all


status:
	sudo docker stack services dummy

