Teste dev. Estadão: Max Willian
==============================

Sobre
--------
Sistema desenvolvido em Laravel + Vue. 

Na parte de backend com Laravel fiz a API, 
usando um banco de dados .sqlite, 
o arquivo ficará dentro da pasta `database`, 
com ele pude usar a ORM do Laravel e facilitar a persistência dos dados.

As rotas da API estão em `routes/api.php` 
apontando para suas devidas Controllers em `app/Http/Controllers`

A SPA foi feita com auxílio do Vue, usando Vuex e Vue Router.

O Vuex fica a cargo do gerenciamento de estado, 
servindo como um armazenamento centralizado para os componentes, 
o arquivo responsável é `resources/js/store.js`.

Já o Vue Router faz o gerenciamento dos componentes que 
devem aparecer na tela da SPA, e muda a URL sem recarregar a página. 
O arquivo que mapeia isso é `resources/js/routes.js`

A única view em PHP é `resources/views/main.blade.php`, 
que carrega o arquivo `resources/js/app.js`, responsável por iniciar o Vue.

Instruções
--------

Após clonar o repositório existem algumas configurações a serem feitas
 
- Copie o arquivo `.env.example` e cole, renomeando-o para `.env`.
- Crie um arquivo com o nome `database.sqlite` dentro da pasta `database`
- Então, execute os seguintes comandos:

```
#instala as dependencias
composer install

#Gera uma chave de encriptação
php artisan key:generate

#roda as migrations
php artisan migrate

#popula a tabela de marcas
php artisan db:seed

#Instala as dependencias do front
npm install

#Coloca a aplicação para rodar, por padrão estará disponível em http://127.0.0.1:8000
php artisan serve
```
