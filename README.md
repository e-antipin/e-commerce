

http://127.0.0.1/api/health-check

Install


bin/console doctrine:migration:migrate

````bash
vendor/bin/php-cs-fixer fix --dry-run --diff
````

````bash
vendor/bin/deptrac analyse --config-file=deptrac-layers.yaml
````

````bash
vendor/bin/phpstan analyse src tests
````