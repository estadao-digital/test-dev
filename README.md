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

- [X] Você deverá desenvolver uma 'mini api' para que seja possível realizar operações CRUD do objeto Carro.
> **Obs:**
> - Você pode usar arquivo (txt, json) como banco de dados.
> - [X] Cada carro deve ter ID, Marca, Modelo, Ano.
> - [X] Foi utilizado bando de dados SQLite.

Sugerimos o retorno dessa 'mini api' nas seguinte urls:

 - [X] `/carros` - [GET] deve retornar todos os carros cadastrados.
 - [X] `/carros` - [POST] deve cadastrar um novo carro.
 - [X] `/carros/{id}`[GET] deve retornar o carro com ID especificado.
 - [X] `/carros/{id}`[PUT] deve atualizar os dados do carro com ID especificado.
 - [X] `/carros/{id}`[DELETE] deve apagar o carro com ID especificado.

### Front-End

Para a segunda etapa do teste, você deverá desenvolver uma SPA (Single Page Application) e nela deve ser possível:

- [X] Ver a lista de carros cadastrados
- [X] Criar um novo carro
- [X] Editar um carro existente
- [X] Apagar um carro existente

> **Obs:**
> - [X] A página deve ser responsiva.
> - [X] A página deve funcionar 100% via AJAX, sem outros carregamentos de páginas.
> - [X] Ao criar/editar um carro, o campo "marca" deverá ser um `SELECT`

### Observações importantes:

- Você não deve se prender aos arquivos do repositório. Fique a vontade para criar outros.
- Você pode usar frameworks, tanto para o front-end, quanto para o back-end, mas um código limpo será melhor avaliado.
- Você pode usar ferramentas de automação (Grunt, Gulp), mas deverá informar o uso completo para funcionamento do teste.
- Será considerado ponto positivo no teste a utilização de JS puro, orientação a objetos, design patterns e rotinas para testes.
- Será considerado ponto positivo o tempo gasto na realização do teste. Menos tempo e tudo funcionando conforme pedido será melhor avaliado.

## Executando o projeto

Faça o clone do projeto para sua máquina e execute os comandos abaixo:

```bash
# Server
$ cd test-dev/server && composer install && composer start

# Client
$ cd test-dev/client && yarn install && yarn start
```

<hr />

Feito por **Joel Fragoso**

- [LinkedIn](https://linkedin.com/in/joel-fragoso)
- [GitHub](https://github.com/joel-fragoso)
