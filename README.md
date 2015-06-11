# git-hook-handler


Just create a `git-hooks.yml` file in your projects base directory, and fill it with an array of commands you want to run:

```yml
pre-commit:
    - bldr run ci
    - phpunit
    - bin/phpcs
post-merge:
    - bldr run compileAssets
```

and then place the following in your composer.json, then run `composer install` or `composer update`

```json
    "scripts": {
        "pre-update-cmd":  "Aequasi\\HookHandler\\HookScript::install",
        "pre-install-cmd": "Aequasi\\HookHandler\\HookScript::install"
    }
```
