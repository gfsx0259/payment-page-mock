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

status:
	sudo docker stack services dummy

