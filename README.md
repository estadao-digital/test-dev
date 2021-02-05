Teste para desenvolvedor do Estadão
==============================

Teste efetuado por Marco Túlio Lacerda usando Laravel 8 no back-end e Vue.js 2(CLI) no front-end 
**Features back-end:**
- Api com validação na entrada de dados
- Upload da foto do veículo
- Seed para auto inserção de dados para testar o sistema

**Features front-end:**
- Responsivo utilizando v-bootstrap
- Validação de campos com vuelidate
- Gerenciador de estado com vuex
- Rotas



Executando o projeto
--------

### Ambiente

Esse teste com um ambiente Docker funcional, ou seja, basta rodar os comandos para subir o container da aplicação e acessar a URL do projeto no navegador.

Para rodar o ambiente, é necessário ter o Docker Compose instalado, e rodar o seguinte comando:
> docker-compose up -d nginx

O back-end precisa ter as dependencias para poder funcionar corretamente. Acesse o terminal do nginx e entre na pasta app com o seguinte comando:
> cd app

Para baixar as depêndencias digite:
> composer install

Agora é preciso criar a base de dados executando as migrations do laravel. Acesse o terminal do nginx  app :
> php artisan migrate

E logo após para preencher o banco com dados de testes
> php artisan db:seed

Agora basta acessar a URL abaixo para visualizar a página que lista os carros cadastrados
> http://localhost:8080

Acesse a URL abaixo para visualizar o dashboard de carros
> http://localhost:8080/#/app/


### Observações importantes:
- O teste só será considerado se rodar através do Docker.
- Caso seja necessário, você pode alterar **qualquer** configuração do Docker. Atente-se apenas para que o ambiente não precise de nenhuma configuração adicional.
- Você não deve se prender aos arquivos do repositório. Fique a vontade para criar outros.
- Você pode usar frameworks, tanto para o front-end, quanto para o back-end, mas um código limpo será melhor avaliado.
- Você pode usar ferramentas de automação (Grunt, Gulp), mas deverá informar o uso completo para funcionamento do teste.
- Será considerado ponto positivo no teste a utilização de JS puro, orientação a objetos, design patterns e rotinas para testes.