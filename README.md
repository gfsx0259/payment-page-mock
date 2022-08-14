## Description
Payment page mock application

![UI example](./build/example/github/example.png)

## Run for develop

* Clone this repository
* Copy and adjust environment `cp .env.example .env`
* Run `docker-compose up -d` in project root directory
* Run `make utils_deps` to download dependencies (only once)
* Run `make utils_example` to extract example database and images 

SPA will be available at:
http://localhost:8083

API will be available at:
http://localhost:8082

Run tests:
```bash
make utils_test
```

## Run for production
Fetch Docker Swarm definition and Makefile.
```bash
curl -s https://raw.githubusercontent.com/gfsx0259/payment-page-mock/main/Makefile
curl -s https://raw.githubusercontent.com/gfsx0259/payment-page-mock/main/docker-compose.prod.yml
```

Deploy the stack to the Docker Swarm:
```bash
make
```
