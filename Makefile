DOCKER_EXEC_PHP = docker-compose exec php
PHPUNIT  = ./vendor/bin/phpunit
PHPCS    = ./vendor/bin/phpcs
PHPLINT  = ./vendor/bin/parallel-lint
COMPOSER = composer

# code quality

phplint:
	$(DOCKER_EXEC_PHP) $(PHPLINT) --exclude .idea --exclude .git --exclude vendor --exclude var .

phpcs:
	$(DOCKER_EXEC_PHP) $(PHPCS) -sp

quality: phplint phpcs

q: quality

# tests

phpunit:
	$(DOCKER_EXEC_PHP) $(PHPUNIT)

pu: phpunit

# other

outdated-php-packages:
	$(DOCKER_EXEC_PHP) $(COMPOSER) show -o -D --strict

opp: outdated-php-packages
