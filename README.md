# git-hook-handler

## Installation

Since this lib is a fork of `aequasi/git-hook-handler`, you must register this repository in your `composer.json` file

```json
# composer.json
	...
    "repositories": [
        {
            "type": "vcs",
            "url": "https://github.com/acseo/git-hook-handler"
        }
    ],
    ...
    "require-dev": {
        "aequasi/git-hook-handler": "^1.0",    
    ...
```

## Usage
Just create a `git-hooks.yml` file in your projects base directory, and fill it with an array of commands you want to run:

```yaml
# git-hook.yml
pre-commit:
    phpunit:
        description : 'Run PHPUnit'
        command : phpunit
        exitcode : 0
    phpcs-fixer:
        description : 'Checking PHP Syntax with PHP-CS-FIXER'
        exitcode : 0
        command : >4
            COMMIT_RANGE='HEAD~..HEAD' &&
            CHANGED_FILES=$(git diff --name-only --diff-filter=ACMRTUXB "${COMMIT_RANGE}") &&
            if ! echo "${CHANGED_FILES}" | grep -qE "^(\\.php_cs(\\.dist)?|composer\\.lock)$"; then IFS=$'\n' EXTRA_ARGS=('--path-mode=intersection' '--' ${CHANGED_FILES[@]}); fi
            && ./vendor/bin/php-cs-fixer fix --config=.php_cs.dist -v --dry-run --using-cache=no "${EXTRA_ARGS[@]}"

post-merge:
    command_name:
        description : 'lorem ipsum'
        command : 'mycommand'
        exitcode : 0
```

and then place the following in your composer.json, then run `composer install` or `composer update`

```json
# composer.json
    "scripts": {
        "pre-update-cmd":  "Aequasi\\HookHandler\\HookScript::install",
        "pre-install-cmd": "Aequasi\\HookHandler\\HookScript::install"
    }
```
