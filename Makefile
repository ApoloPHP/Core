all: phpunit phpdoc

phpunit:
	vendor/bin/phpunit

phpdoc:
	rm -rf build/doc
	vendor/bin/phpdoc
