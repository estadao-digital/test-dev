Introdução
==============================

Este é um sistema simples de cadastro de carros baseado em PHP com MYSQL.
Para desenvolvimento em backend foi utilizado o plugin ActiveRecord:
https://github.com/jpfuentes2/php-activerecord/tree/master

Baseado em PDO

Para FRONTEND foi utilizado bootstrap.



Instalação
==============================

ROTAS:

CONFIGURAR REWRITE BASE no arquivo .htacess

se o acesso for http://localhost/estadao
A configuração deverá ser:

<IfModule mod_rewrite.c>
    RewriteEngine On

	RewriteBase /estadao/
	RewriteCond %{REQUEST_FILENAME} !-f
	RewriteCond %{REQUEST_FILENAME} !-d
	RewriteRule ^(.*)$ index.php?_url=$1 [L]
    # RewriteRule
</IfModule>

A condição "RewriteBase /estadao/" poderá ser alterada conforme necessidade



Configuração:

Arquivo config.php
#CONSTANTE que define URL base do projeto
define('BASE_URL', '/estadao' );

#CONEXAO COM BANCO DE DADOS
$config_database = [
    'host'=>'127.0.0.1',
    'driver'=>'mysql',
    'user' => 'estadao',
    'password'=>'123456',
    'default_database'=>'carros',
];





Teste para desenvolvedor do Estadão
==============================

Olá Desenvolvedor,

Esse teste consiste em 2 etapas para avaliarmos seu conhecimento em PHP e Front-End (HTML5, CSS e JavaScript)

Para realizar o teste, você deve dar um fork neste repositório e depois clona-lo na pasta <document_root> da máquina que está realizando o teste.

Crie um branch com seu nome, e quando finalizar todo o desenvolvimento, você deverá enviar um pull-request com sua versão.


O teste
--------

###Back-End/PHP
A primeira etapa será o desenvolvimento **backend/PHP**:

**Descrição:**

- Você deverá desenvolver uma 'mini api' para que seja possível realizar operações CRUD do objeto Carro.
> **Obs:**
>  - Você pode usar a sessão como banco de dados.
>  - Cada carro deve ter ID, Marca, Modelo, Ano.


- Você deve alterar o arquivo `.htaccess` para criar as seguintes rotas:
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


### Outras observações

 - Você não deve se prender aos arquivos do repositório. Fique a vontade para criar outros.
 - Você pode usar frameworks, tanto para o front-end, quanto para o back-end, mas um código limpo será melhor avaliado.
 - Você pode usar ferramentas de automação (Grunt, Gulp), mas deverá informar o uso completo para funcionamento do teste.
 - Desenvolver em JavaScript puro será considerado um plus.
 - Criar rotinas de teste será considerado um plus.