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
