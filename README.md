## Description
Payment page mock application

![UI example](./build/static/example.png)

## Run for develop

* Clone this repository
* Run `docker-compose up -d` in project root directory

SPA will be available at:
http://localhost:8083

API will be available at:
http://localhost:8082

Run tests:
```bash
docker-compose exec php bash -c "composer test"
```

Dump application tables:
```shell
docker-compose exec db bash -c "mysqldump --no-tablespaces -proot app route callback stub -r "/docker-entrypoint-initdb.d/app.sql""
```

## Run for production
Deploy the stack to the Docker swarm:  
```bash
curl -s https://raw.githubusercontent.com/gfsx0259/payment-page-mock/main/docker-compose.prod.yml | docker stack deploy -c - mystack
```
