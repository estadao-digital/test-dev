# App SPA para gerenciamento de carros

Aplicativo desenvolvido para o cadastro, edição e exclusão de carros.

Além da marca, modelo e ano, é possível também cadastrar uma imagem e uma descrição curta do carro.

### Backend: PHP

### Frontend: Bootstrap, Vue e Jquery

### Banco de dados: arquivo JSON localizado em /statics/data-cars.json

### Ambiente

Esse teste com um ambiente Docker funcional, ou seja, basta rodar os comandos para subir o container da aplicação e acessar a URL do projeto no navegador.

Para rodar o ambiente, é necessário ter o Docker Compose instalado, e rodar o seguinte comando:
> docker-compose up -d nginx

Após o ambiente subir, basta acessar a URL abaixo:
> http://localhost:8080

### Front-End

- http://localhost:8080 - Acessa a o painel para o gerenciamento dos carros

### API Endpoints

- `/carros` - [GET] Retorna todos os carros cadastrados.
- `/carros` - [POST] Cadastra um novo carro.
- `/carros/{id}`[GET] Retorna o carro com ID especificado.
- `/carros/{id}`[PUT] Atualiza os dados do carro com ID especificado.
- `/carros/{id}`[DELETE] Deleta o carro com ID especificado.

### API Payloads
- Adição [POST]

```
    {
        "brand": string - a marca do carro,
        "model": string - o modelo do carro,
        "year": string|int - o ano do carro,
        "image": file - uma imagem do carro,
        "description": string - uma descrição curta do carro
    }
```

- Atualização [PUT]

```
    {
        "brand": string - a marca do carro,
        "model": string - o modelo do carro,
        "year": string|int - o ano do carro,
        "description": string - uma descrição curta do carro
    }
```

## Testes

Para realizar os testes unitários, execute o comando `composer test`

### Observações importantes:
- Como o método PUT não preenche a variável global $_FILES, o envio das imagens só será possível através do método [POST] - Cadastrar um novo carro.
- Adicionei uma página 404 para caso seja acessado um endpoint não registrado nas rotas.
