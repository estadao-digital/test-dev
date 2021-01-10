# Teste to Developer Estadão

### NOTES ABOUT THE PROCESS
This API was made for a Estadão Test and I chose to develop everything without a framework because I think I can show my knowledge better about languages and patterns. Of Course, I could delivery fastly if I would choice a Framework as Laravel.
Another thing is that I could get the brands and the model dynamically in the Fipe API, but I think that for this test I should focus only on the script received and feed only a brands table, wich i will use as static data.

### API - Backend
It is an open API, that is, we are not using an authentication method like Basic, Beared or JWT. You do not need to send authentication parameters in the header.
For the tecnologies I'm using PHP

##

### Don't forget
As we are using Json as DB, dont forget to give permissions for json folder in root of this project


### ENDPOINTS
##### STORE
###### ENDPOINT: {{base_url}}/api/cars/store
###### METHOD: POST
PARAMS:
```
 'name' => ['required', 'minLen' => 2,'maxLen' => 150, 'alpha'], (string)
 'role' => ['required', 'alpha'], (string)
 'school' => ['required', 'minLen' => 2,'maxLen' => 150, 'alpha'], (string)
 'house' => ['required'], (string)
 'patronus' => ['required', 'alpha'] (string)
```
RESPONSE:
````
{
    "success": true,
    "method": "insert",
    "data": [
        {
            "id": "4",
            "name": "Harry Potter",
            "role": "student",
            "school": "Hogwarts School of Witchcraft and Wizardry",
            "house": "1760529f-6d51-4cb1-bcb1-25087fce5bde",
            "patronus": "stag"
        }
    ]
}
````

##### UPDATE
###### ENDPOINT: {{base_url}}/api/cars/update/{{character_id}}
###### METHOD: PUT


PARAMS:
```
 'name' => [ 'minLen' => 2,'maxLen' => 150, 'alpha'], (string)
 'role' => [ 'alpha'], (string)
 'school' => ['required', 'minLen' => 2,'maxLen' => 150, 'alpha'], (string)
 'house' =>  (string)
 'patronus' => ['alpha'] (string)
```
RESPONSE:
````
{
    "success": true,
    "method": "update",
    "data": [
        {
            "id": "2",
            "name": "Harry Potter",
            "role": "student ",
            "school": "Hogwarts School of Witchcraft and Wizardry",
            "house": "1760529f-6d51-4cb1-bcb1-25087fce5bde",
            "patronus": "stag"
        }
    ]
}
````

##### DELETE
###### ENDPOINT: {{base_url}}/api/cars/delete/{{character_id}}
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
###### ENDPOINT: {{base_url}}/api/cars/show/{{character_id}}
###### METHOD: GET

RESPONSE:
````
[
    {
        "id": "3",
        "name": "Harry Potter",
        "role": "student",
        "school": "Hogwarts School of Witchcraft and Wizardry",
        "house": "1760529f-6d51-4cb1-bcb1-25087fce5bde",
        "patronus": "stag"
    }
]
````
##### LIST
###### ENDPOINT: {{base_url}}/api/cars
###### METHOD: GET

RESPONSE:
````
[
    {
        "id": "3",
        "name": "Harry Potter",
        "role": "student",
        "school": "Hogwarts School of Witchcraft and Wizardry",
        "house": "1760529f-6d51-4cb1-bcb1-25087fce5bde",
        "patronus": "stag"
    }
]
````

##### LIST BY CRITERIA
###### ENDPOINT: {{base_url}}/api/cars?{{field}}={{value}}
###### METHOD: GET

Exemplo: {{base_url}}/api/cars?house=1760529f
RESPONSE:
````
{
    "success": true,
    "method": "index",
    "criteria": {
        "key": "house",
        "value": "1760529f"
    },
    "data": [
         {
            "id": "1",
            "name": "emerson udovic ",
            "role": "developer",
            "school": "Hogwarts School of Witchcraft and Wizardry",
            "house": "1760529f-6d51-4cb1-bcb1-25087fce5bde",
            "patronus": "stag"
        },
        {
            "id": "2",
            "name": "Harry Potter",
            "role": "student",
            "school": "Hogwarts School of Witchcraft and Wizardry",
            "house": "1760529f-6d51-4cb1-bcb1-25087fce5bde",
            "patronus": "stag"
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