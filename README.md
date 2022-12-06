Teste para baga de Desenvolvedor  Backend do Estadão
==============================

Olá avaliador(a),

Para execução deste teste serão necessários alguns passos:
1. Primeiro instalamos as dependências com o comando: `$ cd crud_car/backend && composer install`;
1. Ainda na pasta `backend` levantamos o ambiente em docker: `$ ./vendor/bin/sail up -d`;
1. Rodamos as migrações: `$ ./vendor/bin/sail artisan migrate`;
1. Alimentamos o banco de dados executando o arquivo em python: 
    `$ docker exec -i -t backend-laravel.test-1 /bin/bash`
    `$ python3 load_database.py`
    `$ exit`;
1. Rodamos o frontend com: 
    `$ cd ../frontend && npm run` (caso esteja usando o mesmo terminal de ativação e configuração do `backend`)
    ou `$ cd crud_car/frontend && npm run` caso tenha aberto um novo terminal.

Para consumo da API, pode-se importar o arquivo de <i>collections</i> `collection_crud_car.json` no seu cliente REST API de preferência.
O teste
