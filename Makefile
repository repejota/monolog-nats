COMPOSER_PHAR = https://getcomposer.org/composer.phar
CLEAN_FILES = composer.phar composer.lock phpdoc.phar phpcs.phar phpcbf.phar .idea
CLEAN_FOLDERS = bin build cover vendor docs/api
CLEAN_PATHS = $(CLEAN_FILES) $(CLEAN_FOLDERS)

define require_phar
	@[ -f ./$(1) ] || wget -q $(2) -O ./$(1) && chmod +x $(1);
endef

deps:
	$(call require_phar,composer.phar,$(COMPOSER_PHAR))
	./composer.phar install --no-dev

dev-deps:
	$(call require_phar,composer.phar,$(COMPOSER_PHAR))
	./composer.phar install

dist-clean:
	rm -rf $(CLEAN_PATHS)

# Test

test:
	./vendor/bin/phpspec run --format=pretty -v
