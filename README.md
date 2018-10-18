## TESTE DESENVOLVEDOR

Teste utilizando Docker, PHP, Laravel, Vue e MySQL. 

### Instalação

Faça download ou clone via repositório Git.

```sh
$ cd /path/to/install/
$ git@github.com:tcsoares84/test-dev.git
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

* Entre no containner do PHP para instalar as dependências com [Composer](https://getcomposer.org/doc/) :

```sh
$ docker exec -it php-fpm bash
```

* Para instalar as dependências:

```sh
$ composer install --ignore-platform-reqs
```

* Crie uma cópia do arquivo .env para gerenciamento de configurações:

```sh
$ cp .env.example .env
```

* Configure a chave de segurança da aplicação:

```sh
$ php artisan key:generate
```