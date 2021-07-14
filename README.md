# hotels

First, clone the repository.

To install dependencies

```
composer update
```

I chose not to use docker, so pls use your local MySql DB and:

```
php bin/console doctrine:database:create
php bin/console doctrine:migrations:migrate
```

Then load fixtures:
```
php bin/console doctrine:fixtures:load
```

Then 
```
symfony server:start 
```

Enjoy!
