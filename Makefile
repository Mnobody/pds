DOCKER_EXEC_PHP = docker-compose exec php
PHPUNIT  = ./vendor/bin/phpunit
PHPCS    = ./vendor/bin/phpcs
PHPLINT  = ./vendor/bin/parallel-lint
DEPTRAC  = ./vendor/bin/deptrac
COMPOSER = composer

###
### ---------------------------------------------- code quality
###

phplint:
	$(DOCKER_EXEC_PHP) $(PHPLINT) --exclude .idea --exclude .git --exclude vendor --exclude var .

phpcs:
	$(DOCKER_EXEC_PHP) $(PHPCS) -sp

deptrac-layers:
	$(DOCKER_EXEC_PHP) $(DEPTRAC) analyse --config-file=deptrac-layers.yml --report-uncovered

deptrac-modules:
	$(DOCKER_EXEC_PHP) $(DEPTRAC) analyse --config-file=deptrac-modules.yml --report-uncovered

quality: phplint phpcs deptrac-layers deptrac-modules

q: quality

###
### ---------------------------------------------- tests
###

phpunit:
	$(DOCKER_EXEC_PHP) $(PHPUNIT) --group default

phpunit-stemmer-vocabulary:
	$(DOCKER_EXEC_PHP) $(PHPUNIT) --group stemmer-vocabulary

pu: phpunit

###
### ---------------------------------------------- other
###

outdated-php-packages:
	$(DOCKER_EXEC_PHP) $(COMPOSER) show -o -D --strict

opp: outdated-php-packages
