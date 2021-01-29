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

- Você deverá desenvolver uma 'mini api' para que seja possível realizar operações CRUD do objeto Carro.
> **Obs:**
> - Você pode usar arquivo (txt, json) como banco de dados.
> - Cada carro deve ter ID, Marca, Modelo, Ano.

Sugerimos o retorno dessa 'mini api' nas seguinte urls:

 - `/carros` - [GET] deve retornar todos os carros cadastrados.
 - `/carros` - [POST] deve cadastrar um novo carro.
 - `/carros/{id}`[GET] deve retornar o carro com ID especificado.
 - `/carros/{id}`[PUT] deve atualizar os dados do carro com ID especificado.
 - `/carros/{id}`[DELETE] deve apagar o carro com ID especificado.

### Front-End

Para a segunda etapa do teste, você deverá desenvolver uma SPA (Single Page Application) e nela deve ser possível:

- Ver a lista de carros cadastrados
- Criar um novo carro
- Editar um carro existente
- Apagar um carro existente

> **Obs:**
> - A página deve ser responsiva.
> - A página deve funcionar 100% via AJAX, sem outros carregamentos de páginas.
> - Ao criar/editar um carro, o campo "marca" deverá ser um `SELECT`

### Ambiente

Esse teste com um ambiente Docker funcional, ou seja, basta rodar os comandos para subir o container da aplicação e acessar a URL do projeto no navegador.

Para rodar o ambiente, é necessário ter o Docker Compose instalado, e rodar o seguinte comando:
> docker-compose up -d nginx

Após o ambiente subir, basta acessar a URL abaixo e começar a desenvolver:
> http://localhost:8080

### Observações importantes:
- O teste só será considerado se rodar através do Docker.
- Caso seja necessário, você pode alterar **qualquer** configuração do Docker. Atente-se apenas para que o ambiente não precise de nenhuma configuração adicional.
- Você não deve se prender aos arquivos do repositório. Fique a vontade para criar outros.
- Você pode usar frameworks, tanto para o front-end, quanto para o back-end, mas um código limpo será melhor avaliado.
- Você pode usar ferramentas de automação (Grunt, Gulp), mas deverá informar o uso completo para funcionamento do teste.
- Será considerado ponto positivo no teste a utilização de JS puro, orientação a objetos, design patterns e rotinas para testes.