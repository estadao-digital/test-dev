Instruções de funcionamento
==========

Projeto está com o front-end compilado index.html + /js, para rodar basta executar um server php com requerimentos citado abaixo, segue comando abaixo:

$ php -S localhost:8000


Abaixo detalhamento de como testar independente api e front-end.
Tive pouco tempo para fazer, estou em um freela, não conseguir criar os testes :(


Back-End
-----

/api/carros 
/api/marcas


Pasta Fonte: ./api

Framework Lumen 5.5

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


Front-End
-----

Pasta Fonte: ./front-end-source (não compilado)

Angular 2.1


Set up the Development Environment

- Install NodeJS and npm
- Install Angular
- $ npm install -g @angular/cli

Create a new project
- $ ng new my-app

Install dependencies

- $ npm install

Serve the application

- $ ng serve --open 
- or set port
- $ ng serve --open --port=9000

Build project to production
- $ ng build









