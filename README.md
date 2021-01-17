## Aplicação

Esta aplicação realiza o cadastro de carros de acordo com a marca, modelo e ano.

## Importante

- As tabelas do banco de dados são as seguintes:
    * users (Usuários da aplicação)
    * cars (Cadastro dos carros)
    * brands (Marca dos carros)
    * Payload `{
      "marca" : "7",
      "modelo" : Onix,
      "ano" : "2021"
      }`

## Ambiente

Aplicação desenvolvida utilizando o Laravel versão 6, banco de dados Mysql, Swagger e Docker.

A porta para executar a aplicação é a 8083.

Foram criados 3 containers um para executar a  aplicação, sendo, `app-desafio` para a aplicação, `app-mysql` para o banco de dados e `app-mysql-testing` para execução dos testes.

## Instalação

Para executar a aplicação é necessário realizar os procedimentos abaixo:

- Baixar o projeto
- Renomear o arquivo `.env.example` para `.env`
- Executar o comando para criar os cotainers Docker `docker-compose up -d`
- Executar o comando para baixar as dependências `composer install`
    * Ou via Docker, `docker-compose exec app composer install`
- Executar o comando para gerar a nova chave do Laravel `php artisan key:generate`
    * Ou via Docker, `docker-compose exec app php artisan key:generate`
- Executar o comando para criar as tabelas do banco de dados `php artisan migrate`
    * Ou via Docker, `docker-compose exec app php artisan migrate`
- Executar o comando para popular o banco de dados `php artisan db:seed`
    * Ou via Docker, `docker-compose exec app php artisan db:seed`
- Excutar o comando para ativar a fila de processamento `php artisan queue:listen redis`
    * Ou via Docker, `docker-compose exec app php artisan queue:listen redis`

## Endpoints

- Lista todos os usuários da aplicação. A senha de todos os usuários cadastrados é `password`
    * http://localhost:8083/api/users

- Autenticação dos usuários
    * http://localhost:8083/api/auth/login (Efetua o login)
        * Payload `{ "email": "user_email", "password": "user_password" }`
    * http://localhost:8083/api/auth/logout (Efetua logout)
    * http://localhost:8083/api/auth/refresh (Atualiza os dados do token)
    * http://localhost:8083/api/auth/me (Mostra informações do usuário)

- Listagem de todos os carros cadastrados (GET)
    * http://localhost:8083/api/carros

- Cadastro dos carros (POST)
    * http://localhost:8083/api/carros
        * Payload `{ "marca": 7, "modelo": "Celta", "ano": "2011" }`
    
- Dados do carro por ID específicado (GET)
    * http://localhost:8083/api/carros/{id}
    
- Atualização dos dados do carro (PUT)
    * http://localhost:8083/api/carros/{id}
        * Payload `{ "marca": 7, "modelo": "Celta", "ano": "2021" }`
    
- Excluir cadastro do carro (DELETE)
  * http://localhost:8083/api/carros/{id}
    
- SinglePage (Listagem, cadastro, alteração e exclusão dos carros)
    * http://localhost:8083

- Documentação
    * http://localhost:8083/api/documentation (Documentação do endpoint).

## Testes

Para realizar os testes unitários execute o comando `composer tests-unit`
* Ou via Docker, `docker-compose exec app composer tests-unit`


## Desenvolvedor

- Rodrigo Ruy Oliveira
- Email: rro.oliveira@gmail.com
