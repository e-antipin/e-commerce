######################
## Variables		##
######################

DOCKER_COMPOSE = docker-compose -f ./docker/docker-compose.yml
DOCKER_COMPOSE_PHP_FPM_EXEC = ${DOCKER_COMPOSE} exec --user=php php

######################
## Docker 			##
######################
up: docker-up
down: docker-down
restart: down up
bash: docker-bash
clear: docker-clear-all
netstop: docker-network-stop

docker-up:
	${DOCKER_COMPOSE} up --build -d

docker-down:
	${DOCKER_COMPOSE} down -v --remove-orphans

docker-bash:
	${DOCKER_COMPOSE_PHP_FPM_EXEC} bash

docker-clear-all:
	docker system prune

docker-network-stop:
	docker network prune

######################
## Application		##
######################

test:
	${DOCKER_COMPOSE_PHP_FPM_EXEC} bin/phpunit

cache:
	${DOCKER_COMPOSE_PHP_FPM_EXEC} bin/console cache:clear
	${DOCKER_COMPOSE_PHP_FPM_EXEC} bin/console cache:clear --env=test

migrate: db_migrate
diff: db_diff

db_migrate:
	${DOCKER_COMPOSE_PHP_FPM_EXEC} bin/console doctrine:migrations:migrate --no-interaction


db_diff:
	${DOCKER_COMPOSE_PHP_FPM_EXEC} bin/console doctrine:migrations:diff --no-interaction


db_schema_validate:
	${DOCKER_COMPOSE_PHP_FPM_EXEC} bin/console doctrine:schema:validate

db_drop:
	${DOCKER_COMPOSE_PHP_FPM_EXEC} bin/console doctrine:schema:drop --force


##########################
## Static code analysis ##
##########################
phpstan:
	${DOCKER_COMPOSE_PHP_FPM_EXEC} vendor/bin/phpstan analyse -c phpstan.neon; \
 	${DOCKER_COMPOSE_PHP_FPM_EXEC} vendor/bin/phpstan clear-result-cache

deptrac:
	${DOCKER_COMPOSE_PHP_FPM_EXEC} vendor/bin/deptrac analyze --config-file=deptrac-layers.yaml
	${DOCKER_COMPOSE_PHP_FPM_EXEC} vendor/bin/deptrac analyze --config-file=deptrac-modules.yaml

cs_fix:
	${DOCKER_COMPOSE_PHP_FPM_EXEC} vendor/bin/php-cs-fixer fix
linter: cs_fix

cs_fix_diff:
	${DOCKER_COMPOSE_PHP_FPM_EXEC} vendor/bin/php-cs-fixer fix --dry-run --diff

composer_validate:
	${DOCKER_COMPOSE_PHP_FPM_EXEC} composer validate
