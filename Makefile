DOCKER_EXEC_PHP = docker-compose exec php
PHPUNIT  = ./vendor/bin/phpunit
COMPOSER = composer

phpunit:
	$(DOCKER_EXEC_PHP) $(PHPUNIT)

pu: phpunit

outdated-php-packages:
	$(DOCKER_EXEC_PHP) $(COMPOSER) show -o -D --strict

opp: outdated-php-packages
