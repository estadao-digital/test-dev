# SISTEMA DE CADASTRO DE CARROS

## CARACTERÍSTICAS

-   Laravel 5.7
-   VueJs + Vuex + Vue Router
-   Axios
-   Vuetify + Vee Validate + Material Design Icons 

## BACKEND

-   [laravel/laravel](https://github.com/laravel/laravel)
-   [barryvdh/laravel-cors](https://github.com/barryvdh/laravel-cors)

## FRONTEND

-   [vue-cli](https://github.com/vuejs/vue-cli)
-   [vue](https://vuejs.org)
-   [vuex](https://vuex.vuejs.org/)
-   [vue-router](https://router.vuejs.org/)
-   [axios](https://github.com/axios/axios)
-   [Vuetify](https://vuetifyjs.com/en/)
-   [VeeValidate](https://baianat.github.io/vee-validate/)
-   [material-design-icons-iconfont](https://www.npmjs.com/package/material-design-icons-iconfont)

## INSTALAÇÃO

1.  Clone o repositorio
2.  Acesse a pasta backend `cd backed` renomeie o arquivo .env.example para .env `cp .env.example .env` 
3.  Rode o comando `composer install` para instalar as dependencias do laravel
4.  Rode o comando `php artisan key:generate`
5.  Realize a criação de um banco de dados, pode ser MySQL, PostgreSQL ou SQL Server
6.  Após escolher o banco de dados, configure o mesmo no arquivo `.env` nas variaveis `DB_CONNECTION, DB_HOST, DB_PORT, DB_DATABASE, DB_USERNAME, DB_PASSWORD`
7.  Feito isso rode o comando `php artisan migrate` para criar a tabela carros  
8.  Agora vamos iniciar o servidor de backend com o comando `php artisan serve --port 9000`

9.  Volte para raiz com o comando `cd ..`
10. Acesse a pasta frontend com o comando `cd frontend`
11. Rode o comando `npm install`, aguarda a instalação de todas as dependencias
12. Agora rode o comando `npm run serve`
13. Pronto basta acessar a aplicação rodando em: [http://localhost:8080/](http://localhost:8080/) 

## CHANGELOG

Verificar as mudanças realizadas no arquivo [CHANGELOG](CHANGELOG.md).