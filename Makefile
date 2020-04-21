CURRENT_DIRECTORY := $(shell pwd)

test:
	php bin/phpunit

start:
	symfony server:start

stop:
	symfony server:stop

diff:
	php bin/console doctrine:migrations:diff

migrate:
	php bin/console doctrine:migrations:migrate

fixture:
	php bin/console doctrine:fixtures:load
