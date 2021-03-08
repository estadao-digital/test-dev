# Gabriel Morgado

#### O que foi utilizado?
- KrupaBOX (framework backend)
- Twig (template HTML)
- Metronic (template)
- KrupaJS (framework frontend)
- MySQL (banco de dados)

#### Banco de dados
- Criar banco de dados com nome 'test'
- Criar credenciais (usuário: 'root' | senha: 'root')
- O migration é automático no primeiro acesso

#### Host
- Apache
- PHP 7.4
- Mod Rewrite ativado
- Redis

### Teste
- CRUD simples para adicionar/remover/atualizar/deletar carro
- Carro contém marca, modelo e ano
- Marcas são de um fork do banco de dados FIPE (em .json)

# Acesso
- http://localhost

# Endpoints (API Restfull)
- Todos os endpoints podem receber qualquer tipo de dado.
- Ex: form-data, x-www-form-urlencoded ou raw (JSON, YAML, XML).
- O backend automaticamente entende o tipo de dado e converte. 

#### Listar todos carros
- http://localhost/api/car
- Método: GET

#### Adicionar carro
- http://localhost/api/car/add
- Método: GET
- Objeto: {brandId: 1, model: 'Civic', year: 2000}

#### Retornar carro específico
- http://localhost/api/car/{id} (ex: http://localhost/api/car/1)
- Método: GET

#### Atualizar carro específico
- http://localhost/api/car/{id} (ex: http://localhost/api/car/1)
- Método: POST
- Objeto: {brandId: 1, model: 'Civic', year: 2000}

#### Remover carro específico
- http://localhost/api/car/{id} (ex: http://localhost/api/car/1)
- Método: DELETE

# Detalhes

#### Banco de dados
- É possível alterar as credenciais do banco de dados em /Application/Config/Application.json
- Models do banco de dados estão em /Application/Server/Model/

#### Controladores
- Controladores HMVC do backend estão em /Application/Server/Controller/
- Controladores HMVC do frontend estão em /Application/Client/Controller/

#### Router
- Router do backend está em /Application/Server/Event/OnRoute.php
- Router do frontend está em /Application/Client/Event/OnRoute.php

#### HTML
- Views (Twig) está em /Application/Client/View/
- Template (Metronic) está em /Application/Client/Public/packages/metronic/

#### Assets
- SCSSs estão em /Application/Client/Public/assets/scss/ (compilado automaticamente)
- Imagens estão em /Application/Client/Public/img/