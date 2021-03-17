Resultado do teste
==============================


### Back-End/PHP
Rode o comando no terminal na raiz da aplicação:
```sh
composer install    
```

- `/marcas` - [GET] retorna todas as marcas.
- `/carros` - [GET] retornar todos os carros cadastrados.
- `/carros` - [POST] cadastra um novo carro.
- `/carros/{id}` - [GET] retornar o carro com ID especificado.
- `/carros/{id}` - [PUT] atualizar os dados do carro com ID especificado.
- `/carros/{id}` - [DELETE] apaga o carro com ID especificado.


### Front-End

Desenvolvido em react, porém não consegui rodar no Docker.
Todo o código está no diretório **web**.

Das funcionalidade exigidas:
- Ver a lista de carros cadastrados
- Criar um novo carro
- Campo select na tela de criar um novo carro, carrega as marcas da API