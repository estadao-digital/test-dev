## TESTE DESENVOLVEDOR

Teste utilizando Docker, PHP, Laravel, Vue e MySQL. 

### Instalação

Faça download ou clone via repositório Git.

```sh
$ cd /path/to/install/
$ git@github.com:tcsoares84/test-dev.git
```

* Vire a branch para a utilizada no teste e crie uma cópia do arquivo .env para gerenciamento de configurações:

```sh
$ cd test-dev/
$ git checkout ThiagoSoares
$ cp .env.example .env
```

* Se estiver utilizando Git executar o comando para o Git ignorar mudanças de permissões (chmod) em arquivos:

```sh
$ git config core.fileMode false
```

* Configure as permissões de owner e group para os diretórios /storage e /bootstrap.

```sh
$ sudo chgrp -R www-data storage bootstrap/cache
$ sudo chmod -R ug+rwx storage bootstrap/cache
```

* Para rodar o teste é necessárop o uso do Docker para gerenciar os containners da aplicação [Docker](https://www.docker.com/) se nao tiver instalado favor modificar as configurações de banco para local e as .

```sh
$ cd test-dev/env/
$ docker-compose up -d
```

* Entre no containner do PHP para instalar as dependências com [Composer](https://getcomposer.org/doc/):

```sh
$ docker exec -it php-fpm bash
```

* Para instalar as dependências:

```sh
$ composer install --ignore-platform-reqs
```

* Configure a chave de segurança da aplicação:

```sh
$ php artisan key:generate
```

* Rode a migration para criar a tabela no MySQL:

```sh
$ php artisan migrate
```

* Agora instale as dependências de frontend com [npm](https://docs.npmjs.com/):

```sh
$ npm install
```

* Compile os arquivos de JavaScript e CSS:

```sh
$ npm run dev
```

* PS: Por motivo de tempo, acabei não configurando corretamente o Docker e ambiente, então é necessário alterar uma linha de código pelo Gateway do containner gerar um IP diferente a ada vez.
Então em resources/js/views/Cars.vue e resources/js/views/NewCar.vue edite a variavel url com o IP do comando abaixo e no arquivo .env edite o host da conexão com o banco:

```sh
$ docker inspect | grep "Gateway"
```

* Para ver funcionando teste:

```sh
$ http://IPGATEWAYDOCOMANDO:9000
```