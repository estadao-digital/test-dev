## Documentação do projeto

Esse documento tem como objetivo instruir na utilização e instalação do projeto de teste para o Estadão.

**Requisitos:**

- Docker

## Instalação

Execute os comandos abaixo para realizar a instalação do projeto.

```sh
git clone https://github.com/ctcruz/test-dev.git
cd ./test-dev
docker-compose up -d
docker-compose exec app composer install
docker-compose exec node npm install
```

Acesse a URL `http://localhost` para executar o projeto

**Informações adicionais**
A programação frontend foi construída em VueJS e atende através da porta 80. O backend foi feito utilzando Lumen Framework e atende através da porta 81. Como instruído no teste, utilizei como banco de dados um arquivo json localizado em `lumen/storage/app/cars.json`.

**Obs.:** Verifique se a porta 80, 8080 e 81 estão disponíveis no sistema para que não haja conflitos entre as portas do docker.