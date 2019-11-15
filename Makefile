tests: phpunit phpcs-check phpstan ## Run tests suite

phpunit: ## Launch PHPUnit test suite
	sh -c 'vendor/bin/phpunit'

phpcs: ## Apply PHP CS fixes
	sh -c 'vendor/bin/php-cs-fixer fix'

phpcs-check: ## Coding style checks
	sh -c 'vendor/bin/php-cs-fixer fix .php_cs.dist --dry-run'

phpstan: ## Static analysis
	sh -c 'vendor/bin/phpstan analyse --level=max src'

help: ## Display this help message
	@grep -E '^[a-zA-Z_-]+:.*?## .*$$' $(MAKEFILE_LIST) | sort | awk 'BEGIN {FS = ":.*?## "}; {printf "\033[36m%-30s\033[0m %s\n", $$1, $$2}'
