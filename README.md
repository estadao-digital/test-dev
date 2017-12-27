
## Informações
Tecnologias Utilizadas:
- Laravel 5.4
- Eloquent
- MySQL
- Bootstrap
- Izimodal
- Gulp


## Como instalar?

Após clonar o projeto em seu ambiente, siga os seguintes passos:

Utilize o composer  
<pre>
composer install
</pre>

Depos:
<pre>
php artisan key:generate
</pre>


<p>Altere o arquivo .env do seu projeto, mudando as configuraçoes em negrito de acordo com seu banco de dados</p>


<pre>
    DB_CONNECTION=mysql
     DB_HOST=<b>host</b>
     DB_PORT=3306
     DB_DATABASE=<b>database</b>
     DB_USERNAME=<b>usersname</b>
     DB_PASSWORD=<b>password</b>
     </pre>

Após isso, rode o migrate

<pre>
php artisan migrate
</pre>

Popule a tabela
<p>
php artisan db:seed
</p>

e Rode seu projeto

<pre>
php artisan serve
</pre>



## Testes API

via Postman
<pre>

<a href=https://documenter.getpostman.com/collection/view/3434102-2599c12a-393a-d1f3-ce74-e456c1619500">https://documenter.getpostman.com/collection/view/3434102-2599c12a-393a-d1f3-ce74-e456c1619500</a>

</pre>



## Comentários sobre o projeto

Prezados, 

Pelo escopo apresentado fiquei com algumas dúvidas referentes ao projeto teste, como por exemplo sobre a possiblidade de utilização de banco de dados, a criação da API em um projeto separado, o select do tipo 'marca' e outros. 

Finalizei da forma que eu enxergo que é solicitado no teste. 

Gostaria de me apresentar e bater um papo com a equipe. 

Desde já agradeço. 

No mais estou à disposição!