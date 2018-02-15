Teste para desenvolvedor do Estadão
==============================
O teste
--------

###Back-End/PHP
**Descrição:**
MVC desenvolvido por mim mesmo em PHP OO e autoloading dos namespaces. Possui uma camada de serviço para manipulação do arquivo JSON. O acesso a aplicação é feito pela pasta "public".

O nome sugerido para o diretório raiz é "simpleMVC". Caso seja necessária a mudança do nome, o arquivo composer.json deverá ser modificado e executado novamente.

O projeto foi desenvolvido na plataforma Windows. Ao rodar no Linux, fique atento as permissões de arquivos e pastas.

### Front-End
**Descrição:**
Desenvolvido em HTML 5 e CSS 3 para um design minimalista. A programação foi feita em JQuery e ES6, mantendo a simplicidade e a elegancia.
Talvez seja necessário alterar a linha 5 do arquivo header.php (<base href="/simpleMVC/public/" />) para que os javascripts sejam carregados corretamente.

### Testes
Os testes estão disponíveis na pasta "test" e foram desenvolvidos em Jasmine. Hoje os teste de integração do CRUD estão funcionando e novos testes serão desenvolvidos no futuro.

### API
Compartilhei a biblioteca para a API no Postman: https://www.getpostman.com/collections/297f1b78a7db06c368bb

### Observações:
Deu um pouco de trabalho, mas consegui criar um MVC em PHP bem funcional. No frontend eu gostaria de ter utilizado mais javascript puro, porém com o pouco tempo que tinha ficou mais simples separar o JQuery em camadas e trabalhar em conjunto com o ES6. O resultado foi um código organizado e fácil de manter. mais adiante pretendo criar uma biblioteca para tratar a requisição do AJAX, os eventos dos cliques e manipulação do DOM da tabela e do formulário.

De qualquer forma, curti muito esse projeto e espero trabalhar com vocês no futuro.