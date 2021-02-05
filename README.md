Teste para desenvolvedor do Estadão
==============================

Teste efetuado por Marco Túlio Lacerda usando Laravel 8 no back-end e Vue.js 2(CLI) no front-end 
**Features back-end:**
- Api com validação na entrada de dados
- Upload da foto do veículo
- Seed para auto inserção de dados para testar o sistema

**Features front-end:**
- Responsivo utilizando v-bootstrap
- Validação de campos com vuelidate
- Gerenciador de estado com vuex
- Rotas



Executando o projeto
--------

### Ambiente

Esse teste com um ambiente Docker funcional, ou seja, basta rodar os comandos para subir o container da aplicação e acessar a URL do projeto no navegador.

Para rodar o ambiente, é necessário ter o Docker Compose instalado, e rodar o seguinte comando:
> docker-compose up -d nginx

O back-end precisa ter as dependencias para poder funcionar corretamente. Acesse o terminal do nginx e entre na pasta app com o seguinte comando:
> cd app

Para baixar as depêndencias digite:
> composer install

Agora é preciso criar a base de dados executando as migrations do laravel. Acesse o terminal do nginx  app :
> php artisan migrate

E logo após para preencher o banco com dados de testes
> php artisan db:seed

Agora basta acessar a URL abaixo para visualizar a página que lista os carros cadastrados
> http://localhost:8080

Acesse a URL abaixo para visualizar o dashboard de carros
> http://localhost:8080/#/app/


### Testes:
- É possível executar testes no end-pont  /api/cars execute o comando:
>  php artisan test 