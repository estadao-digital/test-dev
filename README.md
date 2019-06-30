Teste para desenvolvedor: Teste-Dev
==============================
 
Este projeto consiste de um CRUD em PHP, que é acessado por meio de uma API rest, e também possui um Front-end para interagir com a API.

--------

### Back-End
 - PHP 
 - Base de Dados (arquivo json)

### Front-End
- HTML
- CSS
- Javascrip
- VueJS
- jQuery
- Bootstrap

### Como usar
````
$ git clone https://github.com/stdioh321/test-dev.git
$ cd test-dev
$ php -S localhost:9999
````
> Acessar o browser no endereço: `http://localhost:9999`

 ![CRUD](https://i.ibb.co/SwVZtSf/CRUD.gif)

### API
 - `/server/api.php/carros` - [GET] Retorna todos os carros.
 - `/server/api.php/carros` - [POST] Cadastra um novo carro.
 - `/server/api.php/carros/{id}`[GET] Retorna um carro especifico.
 - `/server/api.php/carros/{id}`[PUT] Atualiza um carro já existente.
 - `/server/api.php/carros/{id}`[DELETE] Deleta uma carro.

--------

### Pré-Requisitos
 - [PHP](https://www.php.net/downloads.php)