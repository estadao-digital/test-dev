Teste para desenvolvedor do Estadão
==============================

Olá Recrutador.


O teste
--------

###Back-End/PHP
A primeira etapa utilizei um framework que eu mesmo desenvolvi, não se preocupel ele usa padrão MVC e a pasta CORE referente ao teste esta em 
	
		/packages/estadao
		
		Nela voce tem o controller , o model e a view 

**Descrição:**

  Sugiro para execução uma mauina Linux ( ubunut?) com o docker instalado, execute o comando  ./start.sh ele ira preparar o ambiente
  automaticamente para execução
  
  a API  pode ser acessada em  http://127.0.0.1/index.php/carros 
  
  onde:
  
 - `/carros` - [GET] deve retornar todos os carros cadastrados.
 - `/carros` - [POST] deve cadastrar um novo carro.
 - `/carros/{id}`[GET] deve retornar o carro com ID especificado.
 - `/carros/{id}`[PUT] deve atualizar os dados do carro com ID especificado.
 - `/carros/{id}`[DELETE] deve apagar o carro com ID especificado.

### Front-End

Para a segunda etapa  a URL  http://127.0.0.1/carros/app  deverá ser usada para carregar o frontend html. 