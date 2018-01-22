Sistema RESTful - LYNDON MARQUES
==============================

Foi desenvolvido um sistema RESTful uma API para inserção de modelos de carros
 relacionado a marcas já cadastradas no sistema.
 
 Sistema desenvolvido utilizando o framework Codeigniter 3 para back-end, para o front-end foi 
 utilizado HTML5, CSS3, Bootstraps e jQuery com metodologia AJAX.
   
   Como banco de dados foi utilizado 2 arquivos .json, um para armazenar as marcas cadastadas e o outro 
   para armazenamento dos modelos.

API
--------
 
* **_Metodos | URI**_    
- **GET**     | http://localhost/document_root/api/slice/carros 
- **GET{id}** | http://localhost/document_root/api/slice/carros/id/2

- **POST**    | http://localhost/document_root/api/slice/carros

    (OBS) Nome dos input no body:
 
    name  - (STRING)
 
    marca - (INT)
 
    ano   - (INT)
 
- **PUT**     | http://localhost/document_root/api/slice/carros

    (OBS) Nome dos input no body:
    
    id    - (INT)
    
    name  - (STRING)
   
    marca - (INT)
    
    ano   - (INT)
    
    ******Utilizar no HEADER:** 
    
    **Content-type : application/x-www-form-urlencoded******

- **DELETE**  | http://localhost/document_root/api/slice/carros

    (OBS) Nome do input no body:
    
    id    - (INT)

Home
--------

**URI:** http://localhost/document_root/home

**Descrição:**: Listagem dos modelos de carros cadastrado com opção para editar, e deletar o mesmo e
um botão na parte superior para acessar a tela de adicionar novo modelo.

Telas responsivas, 100% funcionais tanto na versão mobile quanto desktop. 


* Desenvolvido com **PHPStorm** por **Lyndon Marques**