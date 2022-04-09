.PHONY: help

help:
	@grep -E '^[a-zA-Z_-]+:.*?## .*$$' $(MAKEFILE_LIST) | sort | awk 'BEGIN {FS = ":.*?## "}; {printf "\033[36m%-30s\033[0m %s\n", $$1, $$2}'

test: ## unit test
	vendor/bin/phpunit

style-fix: ## fix code style with php-cs-fixer
	vendor/bin/php-cs-fixer fix --verbose --show-progress=dots

style: ## test code style with php-cs-fixer
	vendor/bin/php-cs-fixer fix --dry-run --verbose --show-progress=dots

rector: ## test code with Rector
	vendor/bin/rector process --dry-run --verbose

rector-fix: ## fix code with Rector
	vendor/bin/rector process

stan: ## Analyse code with Stan
	vendor/bin/phpstan analyse

lint: ## Checks if code contains syntax errors
	find src -name "*.php" -print0 | xargs -0 -n1 -P8 php -l > /dev/null

phpmetrics: ## Analyse code with PHP Metrics
	vendor/bin/phpmetrics --config=phpmetrics.json

cd: lint stan rector style unit ## run all checks

install: composer.phar ## install dependencies
	php composer.phar install
	rm composer.phar

composer.phar: ## get composer.phar
	wget https://getcomposer.org/download/latest-stable/composer.phar -O composer.phar
