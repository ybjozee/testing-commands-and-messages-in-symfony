# Demo Application on Testing Commands and Messages

This application shows you how to test your messages and commands using PHPUnit.

System Requirements
------------

* PHP 8.2 or above
* PDO-SQLite PHP extension enabled;
* [Git][2]
* [Composer][3]
* [Symfony CLI][4]
* and the [usual Symfony application requirements][5].


Installation
------------

1. Clone the repository

```bash
 git clone https://github.com/ybjozee/testing-commands-and-messages-in-symfony.git test_demo
 cd test_demo
```

2. Install dependencies

```bash
 composer install
```

3. Update `DATABASE_URL` as required - by default, SQLite is used

``` ini
DATABASE_URL="sqlite:///%kernel.project_dir%/var/data.db"
```

4. Setup database

```bash
symfony console doctrine:database:create
symfony console doctrine:database:create --env=test
symfony console doctrine:schema:update --force
symfony console doctrine:schema:update --force --env=test
```

5. Run tests

```bash
composer test
```

[2]: https://git-scm.com/
[3]: https://getcomposer.org/
[4]: https://symfony.com/download
[5]: https://symfony.com/doc/current/reference/requirements.html
