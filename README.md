# Prodis

Prodis, short for [Progressive disclosure](https://en.wikipedia.org/wiki/Progressive_disclosure), is an application made with Symfony for creating documentation that reads more like a walkthrough than a tome.

This is a similar project to [Avenue](https://github.com/carlnewton/avenue), except written in PHP, uses a database and a WYSIWYG editor. If you want to see a demo of the kind of user experience used here without installing, or would prefer a JavaScript/JSON solution, take a look at that project.

## Installation

Create an `.env.local` file in the root directory and add the following:

```
# DATABASE_URL="sqlite:///%kernel.project_dir%/var/data.db"
# DATABASE_URL="mysql://db_user:db_password@127.0.0.1:3306/db_name?serverVersion=5.7"
DATABASE_URL="postgresql://db_user:db_password@127.0.0.1:5432/db_name?serverVersion=13&charset=utf8"
APP_ENV=prod
APP_SECRET=JotDownASecretStringHereButDontChangeItAfterwards
```

Run the following commands:

```sh
composer install
php bin/console doctrine:migrations:migrate
```
