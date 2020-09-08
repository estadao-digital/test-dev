<h1> Teste de Desenvolvimento Web.</h1>

<p> Rode o comando abaixo para iniciar o docker.</p>
<code>docker-compose up</code>

<p>Pegue o ID do seu container do bitnami/laravel:7-debian-10 </p>
<code> docker ps </code>
<p> Acesse o container</p>

<code> docker exec -it ID_DO_SEU_CONTAINER /bin/bash </code>

<p> execute dentro do container</p>
<code> php artisan migrate </code>
<code> php artisan db:seed --class=CarroSeeder</code>


<p> Apos isso configue o front no repositorio: <a href="https://github.com/roderickNascimento/test-dev-front"> https://github.com/roderickNascimento/test-dev-front</a></p>
