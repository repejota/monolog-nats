PHPCS_PHAR = https://squizlabs.github.io/PHP_CodeSniffer/phpcs.phar
COMPOSER_PHAR = https://getcomposer.org/composer.phar
PHPDOCUMENTOR_PHAR_URL = https://github.com/phpDocumentor/phpDocumentor2/releases/download/v2.9.0/phpDocumentor.phar

CLEAN_FILES = composer.phar \
			  composer.lock \
			  phpdoc.phar \
			  phpcs.phar \
			  phpcbf.phar \
			  .idea
CLEAN_FOLDERS = bin \
				build \
				cover \
				vendor \
				docs/api
CLEAN_PATHS = $(CLEAN_FILES) $(CLEAN_FOLDERS)

SOURCE_CODE_PATHS = src

API_DOCS_PATH = ./docs/api

define require_phar
	@[ -f ./$(1) ] || wget -q $(2) -O ./$(1) && chmod +x $(1);
endef

# Lint

.PHONY: lint
lint: lint-php lint-psr2

.PHONY: lint-php
lint-php:
	find $(SOURCE_CODE_PATHS) -exec php -l {} \;

.PHONY: lint-psr2
lint-psr2:
	$(call require_phar,phpcs.phar,$(PHPCS_PHAR))
	./phpcs.phar --standard=PSR2 --colors -w -s --warning-severity=0 $(SOURCE_CODE_PATHS)

# Dependencies

deps:
	$(call require_phar,composer.phar,$(COMPOSER_PHAR))
	./composer.phar install --no-dev

dev-deps:
	$(call require_phar,composer.phar,$(COMPOSER_PHAR))
	./composer.phar install

# Clean

clean: dist-clean

dist-clean:
	rm -rf $(CLEAN_PATHS)

# Test

test:
	./vendor/bin/phpspec run --format=pretty -v

cover:
	./vendor/bin/coveralls -f clover.xml

docker-nats:
	docker run -p 8222:8222 -p 4222:4222 -d --name nats-main nats

phpdoc:
	$(call require_phar,phpdoc.phar,$(PHPDOCUMENTOR_PHAR_URL))
	./phpdoc.phar -d ./src/ \
		-t $(API_DOCS_PATH) \
		--template=checkstyle \
		--template=responsive-twig

serve-phpdoc:
	cd $(API_DOCS_PATH) && php -S localhost:8000 && cd ../..

