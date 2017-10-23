# Teste para SliceTI
Repositório para o projeto de teste da Slice-TI

## Instruções
Copie ou clone este projeto

    git clone https://github.com/matPK/test-dev.git

Entre na pasta do projeto e baixe as dependências

    composer update

Copie e renomeie o arquivo ``.env.example`` para ``.env`` e configure nele os dados de conexão ao banco de dados que você criou para a aplicação.

    DB_CONNECTION=mysql
    DB_HOST=host
    DB_PORT=porta
    DB_DATABASE=banco
    DB_USERNAME=usuário
    DB_PASSWORD=senha

Gere uma chave da aplicação.

    php artisan key:generate

Migre o banco de dados.

    php artisan migrate

Semeie o banco de dados.

    php artisan db:seed

Rode o servidor local.

    php artisan serve

Acesse ``http://localhost:8000`` e teste a aplicação.

## Autoria
Desenvolvido por ``Matheus Adorni Dardenne``.