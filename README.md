HYKY : Services
===============

> A PHP backend for basic APIs using Slim and Doctrine, inspired by [YAPI][0] and other small projects. We've got doughnuts! :doughnut: (not really)

This project aims to offer a simple and easy to handle API backend for small (and maybe mid-sized) projects, where not many resources and features are needed, though we also want to maintain scalability (because who knows? :wink:).

The idea is to have most of the hard work done for some very basic stuff, like authentication layer, account, user and role management, among other basic things, so we only have to code additional endpoints and entities in future projects based on this.

This project is a twin project with the **[HYKY : Manage][1]** project, which aims to offer a basic administrator structure to manage/consume the API.

-----

## Requirements

- Apache Server `v2.4+` or Nginx `v1.12+`
  - _The server must have URL rewriting activated_
- PHP `v7.0.18+`
  - _You'll need `PDO` and the `SQLite` and `MySQL` drivers_
- MySQL `v5.6.35+` or MariaDB `v10.1.22+`
- Composer `v1.6.2+`

It's not required, but we strongly advise you to configure a vanity domain for local development, since it might help in development/testing.

-----

## Dependencies

Once you have all the requirements set up, just run `composer install` on this project's folder and all dependencies will be installed automatically.

For reference, here are all the current dependencies:
- **slim/slim** `v3.9+`
- **doctrine/orm** `v2.5+`
- cocur/slugify `v3.1+`
- firebase/php-jwt `v5.0+`
- monolog/monolog `v1.23+`
- oscarotero/psr7-middlewares `v3.21+`
- ramsey/uuid `v3.7+`
- tuupola/cors-middleware `v0.5.2+`
- tuupola/slim-jwt-auth `v2.3+`
- vlucas/phpdotenv `v2.4+`

These are the development dependencies:
- phpunit/phpunit `v6.5+`

There will be a documentation for this project very soon, which will depend on `node.js`.

-----

## How To Run

#### TL;DR
- Clone;
- Run `composer install`;
- Copy `.env.example` into `.env` and set all the data to your current setup;
- Run `schema-update.bat` (windows) or `php vendor\bin\doctrine orm-schema-tool:update --force` (linux);
  - _You should do this every time you change something in the `api\model\entity` folder;
- If you still didn't initialize the user data, run `bootstrap-data.bat`;
  - This script initializes the basic user roles, permissions, groups and users from the data inside `data\bootstrap`, customize the data according to your needs;
  - Initial user data: **Username:** `admin` / **Password:** `admin`
- Serve the contents of the `public` folder;

_More and better instructions coming up in the next episode! (A bit delayed, but someday...maybe...)_

-----

## Authors

This project's developed mainly by the **[HYKY Team][hyky]** collective. See `AUTHORS.md` for more information and, maybe, some contact info.

-----

_©2018 HYKY Team_

[0]: https://github.com/yuigoto/yx-php-yapi
[1]: https://github.com/HYKY/hyky-manage
[hyky]: https://hyky.games
