# fast_api
O back end foi construido com o https://github.com/mmfjunior1/fast_api, desenvolvido por mim durante um projeto.
Utilizado Angular 1 no front end.
# Importante
A pasta database deve estar com permissão de escrita para o www-data, bem como o arquivo do banco de dados.
# .environment
Nesse arquivo configuramos o caminho do arquivo do banco de dados. É importante apontar para o local correto para que tudo funcione bem. O banco de dados já foi enviado nesse commit. 
# Configuração utilizada aqui no meu servidor
Se utilizar essa configuração, bastará colonar o projeto.
Seguem os passos:
# 1 - Clonar o projeto em /var/www/html (Se for linux)
# 2 - Dê permissão de escrita para a database/carros.sqlite3
# 3 - Crie o Vhost abaixo e, após criar, acesse http://127.0.0.1:8081/web/#!/car/list/
Listen 8081

        <VirtualHost _default_:8081>
                ServerAdmin webmaster@localhost
                DocumentRoot /var/www/html/test-dev/public
                
                Alias /_testBed /var/www/pma

                <FilesMatch "\.(cgi|shtml|phtml|php)$">
                                SSLOptions +StdEnvVars
                </FilesMatch>

                BrowserMatch "MSIE [2-6]" \
                                nokeepalive ssl-unclean-shutdown \
                                downgrade-1.0 force-response-1.0
                # MSIE 7 and newer should be able to use keepalive
                BrowserMatch "MSIE [17-9]" ssl-unclean-shutdown
        </VirtualHost>
