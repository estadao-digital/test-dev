Teste Guilherme Camacho
==============================

Olá Avaliador,

Realizei o teste com inicio dia  10/01/2018 as 20:00

Para verificar o como ficou basta utilizar o proprio microserver do php 
 
Nos meus testes e durante o desenvolvimento usei ele para fazer o mesmo basta entrar na pasta e execultar o sequinte comando

`php -S localhost:8080`

Criei uma branch com o meu nome Guilherme-camacho para ficar mais facil assim como foi solicitado


O teste
--------

###Back-End/PHP
A primeira etapa será o desenvolvimento **backend/PHP**:

**Descrição:**

- Criei uma api's e um crawler
> **API's:**
>  - A propria api soliciatada no teste
>  - Um mini crawler que com base nos dados do carro "marca modelo ano" busca essas informacoes no google e obtem uma imagem que deve ser a do carro
>  - Tambem apartir de uma outra api busquei os dados do carro apartir da tabela FIPE 

- Esta funcionando como foi selecionado:
 - `/api/carros` - [GET] deve retornar todos os carros cadastrados.
 - `/api/carros` - [POST] deve cadastrar um novo carro.
 - `/api/carros/{id}` - [GET] deve retornar o carro com ID especificado.
 - `/api/carros/{id}` - [PUT] deve atualizar os dados do carro com ID especificado.
 - `/api/carros/{id}`[DELETE] deve apagar o carro com ID especificado.
 - `/api/extra.php?img={marca}+{modelo}+{ano}` - [GET] retora a url da primeira imagem resultante do google imagens
 - `/api/extra.php?marca` - [GET] retorna a lista com todas as marcas de carros da tabela fipe
 - `/api/extra.php?marca={marcacode}&modelo` - [GET] retorna a lista com todos modelos
 - `/api/extra.php?marca={marcacode}&modelo={modelocode}&ano` - [GET] retorna a lista com todos os anos do modelo
 - `/api/extra.php?marca={marcacode}&modelo={modelocode}&ano={anocode}` - [GET] retorna todos os dados do veiculo

- Testes de resposta disponiveis para quem usa o POSTMAN 
https://www.getpostman.com/collections/c3b1bf95ab794869e342 

- View geral das requisições
https://documenter.getpostman.com/collection/view/242542-b53143e8-afd0-090b-8867-4b71191cec81

### Front-End

Criei um SPA utilizando apenas AJAX como soliciatado nesse caso eu criei usando as seguintes tecnologias

- Jquery, Bootstrap para o design

Todos os requisitos estao na aplicacao

- Ver a lista de carros cadastrados - **Compra**
- Criar um novo carro - **Venda**
- Editar um carro existente - **Compra clicando no carro e em editar**
- Apagar um carro existente - **Compra clicando no carro e em apagar**

> **Obs:**
> - A Pagina esta responsiva e com os requisitos
> - Todo o item de **Venda** esta dinamico utilizando os select e buscando na api os dados das marcas, modelos e anos


### Observações importantes:

 - Você não deve se prender aos arquivos do repositório. Fique a vontade para criar outros.
    - Criei outros arquivos e pastas - *Mudei a api para uma pasta api onde contem todo os codigos de backend*
 - Você pode usar frameworks, tanto para o front-end, quanto para o back-end, mas um código limpo será melhor avaliado.
    - Utilizei para o Bront: JQUERY, bootstrap
    - Utilizei para o Back: php "puro" e algumas bibliotecas para a base de dados em json e prara o crawler 
 - Será considerado ponto positivo no teste a utilização de JS puro, orientação a objetos, design patterns e rotinas para testes.
    - Infelizmente não daria para fazer tudo em JS puro como gostaria devido a meu tempo.
 - Será considerado ponto positivo o tempo gasto na realização do teste. Menos tempo e tudo funcionando conforme pedido será
melhor avaliado.
    - Fiz tentei fazer todo o processo em menos tempo posssivel nesse teste monitorei o meu tempo de execução que foi de 13:00 Horas de programacao.
