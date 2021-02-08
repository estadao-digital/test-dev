Teste para desenvolvedor do Estadão
==============================

Teste efetuado por Marco Túlio Lacerda usando Laravel 8 no back-end e Vue.js 2(CLI) no front-end 
**Features back-end:**
- Api com validação na entrada de dados
- Upload da foto do veículo
- Seed para auto inserção de dados para testar o sistema
- Teste automatizado da api de carros

**Features front-end:**
- Responsivo utilizando v-bootstrap
- Validação de campos com vuelidate
- Gerenciamento de estado com vuex
- Rotas



Executando o projeto
--------

### Ambiente

Esse teste com um ambiente Docker funcional, ou seja, basta rodar os comandos para subir o container da aplicação e acessar a URL do projeto no navegador.

Para rodar o ambiente, é necessário ter o Docker Compose instalado, e rodar o seguinte comando:
> docker-compose up -d nginx

O back-end precisa ter as dependencias para poder funcionar corretamente. Todos os comandos a seguir devem ser executados na imagem estadao-test-dev-app. No terminal digite:
> docker exec -it estadao-test-dev-app bash

Entre na pasta app com o seguinte comando:
> cd app

Para baixar as depêndencias do projeto digite:
> composer install

Gere uma chave para o arquivo de configuração do laravel com o seguinte comando
>php artisan key:generate

Defina a conexão com o banco de dados. Altere o nome do arquivo .env.example para .env e configure o banco com os seguintes dados:

DB_CONNECTION=mysql<br />
DB_HOST=db<br />
DB_PORT=3306<br />
DB_DATABASE=estadao<br />
DB_USERNAME=root<br />
DB_PASSWORD=root

Agora é preciso criar a base de dados executando as migrations do laravel. Acesse o terminal do nginx  app :
> php artisan migrate

E logo após execute o comando abaixo para preencher o banco de dados com dados de testes
> php artisan db:seed

Acessar a URL abaixo para visualizar a página que lista os carros cadastrados
> http://localhost:8080

Acesse a URL abaixo para visualizar o dashboard de carros
> http://localhost:8080/#/app/


### Testes:
- É possível executar testes no end-pont  /api/cars execute o comando no terminal dentro da pasta app:
>  php artisan test 