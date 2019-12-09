CURRENT_DIRECTORY := $(shell pwd)

test:
	php bin/phpunit

start:
	symfony server:start
