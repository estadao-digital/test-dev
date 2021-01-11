# Test to Developer Estadão

### NOTES ABOUT THE PROCESS
This API was made for a Estadão Test and I chose to develop everything without a framework because I think I can show my knowledge better about languages and patterns. Of Course, I could delivery fastly if I would choice frameworks.

### API - Backend
It is an open API, that is, we are not using an authentication method like Basic, Beared or JWT. You do not need to send authentication parameters in the header.
About the tecnologies:
PHP
JSON

### FRONTEND
I decided not to use any framework to do this, but there is something to run, especially if you want to edit the js or scss files.
The files before compilation are in the "src" folder and then in the "dist" folder.
About the tecnologies:
JS
Jquery
Scss
HTML
CSS
Webpack
Gulp

Run:
npm install -g gulp-cli
npm install

For prod:
gulp sass-prod
npm run build


### Don't forget
As we are using Json as DB, dont forget to give permissions for json folder in root of this project


### ENDPOINTS
##### STORE
###### ENDPOINT: {{base_url}}/api/cars/store
###### METHOD: POST
PARAMS:
```
    'carro' => ['required', 'minLen' => 2,'maxLen' => 50],
    'marca' => ['required', 'minLen' => 2,'maxLen' => 50],
    'modelo' => ['required', 'minLen' => 2,'maxLen' => 50],
    'ano' => ['required', 'minLen' =>4,'maxLen' => 4, 'numeric']
```
RESPONSE:
````
{
    "success": true,
    "method": "insert",
    "data": {
        "id": "d0970556f20f1a045ef3090bf9719bac",
        "carro": "gol",
        "marca": "volks",
        "modelo": "GTI",
        "ano": "1990"
    }
}
````

##### UPDATE
###### ENDPOINT: {{base_url}}/api/cars/update/{{car_id}}
###### METHOD: PUT


PARAMS:
```
    'carro' => ['required', 'minLen' => 2,'maxLen' => 50],
    'marca' => ['required', 'minLen' => 2,'maxLen' => 50],
    'modelo' => ['required', 'minLen' => 2,'maxLen' => 50],
    'ano' => ['required', 'minLen' =>4,'maxLen' => 4, 'numeric']
```
RESPONSE:
````
{
    "success": true,
    "method": "update",
    "data": {
        "id": "d0970556f20f1a045ef3090bf9719bac",
        "carro": "gol",
        "marca": "volks",
        "modelo": "gts",
        "ano": "2001"
    }
}
````

##### DELETE
###### ENDPOINT: {{base_url}}/api/cars/delete/{{car_id}}
###### METHOD: DELETE

RESPONSE:
````
{
    "success": true,
    "method": "delete",
    "data": {
        "id": "1"
    }
}
````

##### GET BY ID
###### ENDPOINT: {{base_url}}/api/cars/show/{{car_id}}
###### METHOD: GET

RESPONSE:
````
{
    "success": true,
    "method": "show",
    "data": {
        "id": "d0970556f20f1a045ef3090bf9719bac",
        "carro": "gol",
        "marca": "volks",
        "modelo": "gts",
        "ano": "2001"
    }
}
````
##### LIST
###### ENDPOINT: {{base_url}}/api/cars
###### METHOD: GET

RESPONSE:
````
{
    "success": true,
    "method": "list",
    "data": [
        {
            "id": "7b6c37a780ebee9fbd7efd7f0cde942b",
            "carro": "Santa fé",
            "marca": "HYUNDAI",
            "modelo": "v6",
            "ano": "2010"
        },
        {
            "id": "4cdc7c2f3b2f97a98e9a49642597b2de",
            "carro": "audi m3",
            "marca": "AUDI",
            "modelo": "im a test model",
            "ano": "2021"
        },
        {
            "id": "d0970556f20f1a045ef3090bf9719bac",
            "carro": "gol",
            "marca": "volks",
            "modelo": "gts",
            "ano": "2001"
        }
    ]
}
````


### Units Tests
Its not usually or security to use an API route to tests, but to simple the process for analize, the endpoint "tests" was created.
You else can test by the follow way:

```php
use App\Tests\Tests;

Tests::runTests();

```
