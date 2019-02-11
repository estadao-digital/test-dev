Teste para desenvolvedor do Estadão
==============================

Olá candidato,

Esse teste consiste em 2 etapas para avaliarmos seu conhecimento em PHP e Front-End (HTML5, CSS e JavaScript)

Para realizar o teste, você deve dar um fork neste repositório e depois clona-lo na pasta <document_root> da máquina que está realizando o teste.

Crie um branch com seu nome, e quando finalizar todo o desenvolvimento, você deverá enviar um pull-request com sua versão.

O teste
--------

### Back-End/PHP

A primeira etapa será o desenvolvimento **backend/PHP**:

**Descrição:**

- Você deverá desenvolver uma 'mini api' para que seja possível realizar operações CRUD do objeto Carro.
> **Obs:**
> - Você pode usar arquivo (txt, json) como banco de dados.
> - Cada carro deve ter ID, Marca, Modelo, Ano.

Sugerimos o retorno dessa 'mini api' nas seguinte urls:

 - `/carros` - [GET] deve retornar todos os carros cadastrados.
 - `/carros` - [POST] deve cadastrar um novo carro.
 - `/carros/{id}`[GET] deve retornar o carro com ID especificado.
 - `/carros/{id}`[PUT] deve atualizar os dados do carro com ID especificado.
 - `/carros/{id}`[DELETE] deve apagar o carro com ID especificado.

### Front-End

Para a segunda etapa do teste, você deverá desenvolver uma SPA (Single Page Application) e nela deve ser possível:

- Ver a lista de carros cadastrados
- Criar um novo carro
- Editar um carro existente
- Apagar um carro existente

> **Obs:**
> - A página deve ser responsiva.
> - A página deve funcionar 100% via AJAX, sem outros carregamentos de páginas.
> - Ao criar/editar um carro, o campo "marca" deverá ser um `SELECT`

### Observações importantes:

- Você não deve se prender aos arquivos do repositório. Fique a vontade para criar outros.
- Você pode usar frameworks, tanto para o front-end, quanto para o back-end, mas um código limpo será melhor avaliado.
- Você pode usar ferramentas de automação (Grunt, Gulp), mas deverá informar o uso completo para funcionamento do teste.
- Será considerado ponto positivo no teste a utilização de JS puro, orientação a objetos, design patterns e rotinas para testes.
- Será considerado ponto positivo o tempo gasto na realização do teste. Menos tempo e tudo funcionando conforme pedido será melhor avaliado.

### Requisitos
- PHP >= 7.1.3
- OpenSSL PHP Extension
- PDO PHP Extension
- Mbstring PHP Extension
- Tokenizer PHP Extension
- XML PHP Extension
- Ctype PHP Extension
- JSON PHP Extension
- BCMath PHP Extension
- COMPOSER
- NPM

### Instalação
- Este projeto utiliza Laravel 5.7 como backend e Vuejs 2 para fazer o front-end

- Clone o repositorio `git clone https://github.com/matheusisla/test-dev.git`
- Acesse a pasta `cd teste/`
- Execute o comando `composer install`
- Execute o comando `npm install`
- crie uma cópia do arquivo .env.example com o nome .env `cp .env.example .env`
- crie um arquivo database.sqlite na pasta database
- abra o arquivo .env e edit nas linha subsitua :

> - DB_CONNECTION=mysql
> - DB_HOST=127.0.0.1
> - DB_PORT=3306
> - DB_DATABASE=homestead
> - DB_USERNAME=homestead
> - DB_PASSWORD=secret

Por apenas ou por suas credenciais do mysql
> - DB_CONNECTION=sqlite
- Salve o arquivo
- Execute o comando `php artisan key:generate`
- Execute o comando `php artisan migrate` irá instalar a estrutura de banco de dados
- Execute o comando `php artisan db:seed` este comando irá adicionar dados ficticios 
- Para compilar o frontend `npm run prod` minificado
- Para executar sem ter a necessidade de configurar um virtual host `php artisan serve` se for configurar utilizar a pasta public como document root

### Observações:
- Códigos de scss e css ficam no diretório `/resources/sass/` quando compilados ficam em `/public/css`
- Códigos js ficam no diretório `/resources/js/` e os components do vue `/resources/js/components/` quando compilados ficam em `/public/js`
- Códigos fonte das views ficam no diretório `/resources/views/`
- Códigos fonte das rotas web ficam em `/routes/web.php`
- Códigos fonte das rotas API ficam em `/routes/api.php`
- Códigos com estrutura do banco de dados `/database/migrations`
- Códigos com estrutura do dados ficticios `/database/seeds`