Framework Lumen 5.5
--------

Server Requirements

- PHP >= 7.0
- OpenSSL PHP Extension
- PDO PHP Extension
- Mbstring PHP Extension


Installing Lumen

- $ composer global require "laravel/lumen-installer"


Creating new project sample

- $ lumen new blog


Installing dependencies

- $ composer install


Serving Your Application

- $ php -S localhost:8000


Upload path (project dont use db mysql, use json)

- $ chmod 777 database/seeds/data/carros.json
- $ chmod 777 database/seeds/data/marcas.json