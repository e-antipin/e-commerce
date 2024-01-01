up: docker-up
down: docker-down
restart: down up
bash: docker-bash
close-all: docker-close-all
netstop: docker-network-stop

docker-up:
	docker-compose up --build -d

docker-down:
	docker-compose down --remove-orphans

docker-down-clear:
	docker-compose down -v --remove-orphans

docker-bash:
	docker-compose exec --user=php php bash

docker-clear-all:
	docker stop `docker ps -qa`
	docker rm `docker ps -qa`
	docker rmi -f `docker images -qa `
	docker volume rm $(docker volume ls -qf dangling="true")
	docker network rm `docker network ls -q`

docker-close-all:
	docker stop `docker ps -qa`

docker-network-stop:
	docker network prune