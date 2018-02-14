Teste para desenvolvedor do Estadão
==============================

* API RESTful em PHP utilizando o framework Slim que realiza operações de CRUD de carros.
* Aplicação web SPA (Single page application) para fazer a interface com a API. Foi utilizado o framework de UI Bootstrap.

## Configuração do banco de dados
--------

Foi utilizado um banco de dados mysql para esta aplicação.

Para configurá-lo, vá em api/config/database.php e atualize as informações de host, username, password e database.

Para criar o banco de dados, rode o script localizado na pasta scripts chamado createdb.bat (Caso esteja rodando em um mac ou linux, você pode simplesmente rodar o arquivo createdb.php chamando-o em seu browser)


--------
## Padrão das Rotas Criadas para a API: 

Segue abaixo as URI's das rotas desenvolvidas:

|ROTA|HTTP(Verbo)| Descrição | 
|--|--|--|
| /carros | GET | Selecionar todos os carros |
| /carros/:id | GET | Selecionar carro por id |
| /carros  | POST| Cadastrar carro|
| /carros/:id/  | DELETE| Excluir carro por Id |
| /carros/:id/  | PUT| Editar carro por Id |
| /marcas | GET | Selecionar as marcas |

## Observações Finais:

* Gostei muito de desenvolver este teste, tive a oportunidade de demonstrar minhas habilidades, organização de código e boas práticas de programação.

* Trabalho a 5 anos com desenvolvimento Web utilizando PHP e frameworks como Codeigniter, CakePHP e Laravel;

* Para a parte back-end foi utilizado o framework Slim, apenas para lidar com as rotas. A Model e a Controller foram desenvolvidos por mim, de modo a deixar o código reutilizável e a manutenção facilitada.

* Para a parte front-end, foi utilizado o framework bootstrap e os botões do fonts-awesome;

* A página está responsiva.

* A página funciona 100% via AJAX, sem outros carregamentos de páginas.

* Ao criar/editar um carro, o campo "marca" é um SELECT, baseado nas marcas já cadastradas em outros carros. Foi utilizado o elemento datalist do HTML5 que permite mostrar uma lista e também permite inserir novas entradas livremente, não necessiitando portanto de um cadastro de marcas.

* No javascript foi utilizado apenas jQuery e poucos elementos do bootstrap

* Foi utilizado orientação a objetos e design patterns

* Os Unit Tests não foram disponibilizados pois estavam dando alguns erros e não tive tempo de estudar como resolve-los.
