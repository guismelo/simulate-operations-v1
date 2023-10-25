# API EPICS - v2

<p align="center">
    <img src="https://www.epics.com.br/assets/logos/logo-epics.svg" align="center" alt="Epics" width="140"/>
</p>

<p align="center">
    <a href="http://makeapullrequest.com">
        <img src="https://img.shields.io/badge/PRs-welcome-brightgreen.svg?style=flat-square" alt="PRs Welcome">
    </a>
    <a href="https://en.wikipedia.org/wiki/Proprietary_software">
        <img src="https://img.shields.io/badge/license-Proprietary-blue.svg?style=flat-square" alt="License MIT">
    </a>
</p>

## Configure

### Database
- **Version:** MySQL 5.7
- **Name:** all epics database
- **Migration:** [EPICS ULI Migration](https://github.com/epicsweb/database-migration-v1)
---
### Back-end
- **Host:** api.v2.epics
- **PHP:** ^8.0
---
### Install & Requeriments
#### Requeriments
- Laravel 8.x Requeriments https://lumen.laravel.com/docs/5.8
- PHP ^8.0
- MySQL 5.7
- Composer && php artisan installed
--
#### Install
- Clone this repository on a clean folder: [Github](https://github.com/epicsweb/api-epics-v2)
- Use "composer install" on repository folder
- Run `cp .env.example .env` and configure your `.env` file
- Run `php artisan key:generate`
- If you are using MAMP, set in your ".env" `DB_SOCKET='/Applications/MAMP/tmp/mysql/mysql.sock'`
#### Routes
---
- Attention to the new patterns d of route files:
    - `routes/web.php` is the public route: www.yoursite.com/public/{your-route} (no auth)
    - `routes/api.php` don`t use this file to create routes
    - `routes/api/{filename}.php` is default route: www.yoursite.com/{your-route} (need auth)
        - `filename` will be the `->prefix()` and `->name()` default

- Use Laravel patterns to use all routes:
| Verb | Path | Action | Route Name | Desc |
|--|--|--|--|--|
| GET | /user | index | user.index | get all users |
| GET | /user/create | create | user.create | view to create user |
| POST | /user | store | user.store | save new user |
| GET | /user/{id} | show | user.show | get and user |
| GET | /user/{id}/edit | edit | user.edit | get user data to edit |
| PATCH/PUT | /user/{id} | update | user.update | save new user data |
| DELETE | /user/{id} | destroy | user.destroy | delete an user |
---
#### Create models
- You can use [reliese/laravel](https://github.com/reliese/laravel) library to generate a new model
- Get your connection name in `database.php` file
- Change the options at file `config.models.php` just to create:
    - `'path' => app_path('Models/{databasePath}'),`
    - `'namespace' => 'App\Models\{databasePath}',`
- To generate this, use this command:
    - `php artisan code:models --connection=mysql_{...} --table={tableName}`
---
#### Create repositories
- You can use this custom command to generate a new repository
    - `php artisan repository:create {databasePath} {modelName}`
    - `php artisan repository:create {databasePath} all`
---
#### Code Sniffer & Code Beautifier
Use this commands for keep code defaults:
- PHP Code Sniffer
    - ```composer phpcs``` or  ```php vendor/bin/phpcs```
- PHP Code Beautifier and Fixer
    - ```composer phpcbf``` or ```php vendor/bin/phpcbf```
---
- This code cannot be reproduced or used commercially;
