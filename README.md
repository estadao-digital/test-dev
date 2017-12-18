

EXECUTAR ANTES DA APLICAÇÃO CLIENTE

1- Criação do Database (Mysql) executar DUMP de storage/database/database.sql

2 - Alterar parametros no .env para o Banco DB_CONNECTION=mysql DB_HOST=127.0.0.1 DB_PORT=3306 DB_DATABASE=jwt_test DB_USERNAME=root DB_PASSWORD=testes

3 - RODAR migrations e seeds - executar na raiz - php artisan migrate - php artisan db:seed

4 - Bateria de testes usando sqlite com o comando phpunit na raiz do projeto

RECURSOS: Listagem de Carros Edição de carros Inserção de carros Exclusão de carros


Também disponivel em:
https://brunocaramelo.com/poc/car_test/public/
