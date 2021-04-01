<?php
declare(strict_types=1);

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\App;

return function (App $app) {
    // API root route. Can be used to populate a basic records file.
    $app->get('/api[/]', function (Request $request, Response $response, $args) {
        // Creates an standard array.
        $aux_array = array(
            array(
                'id'            => 0,
                'marca'         => 'Chevrolet',
                'modelo'        => 'Monza',
                'ano'           => 1980,
                'dt_creation'   => date('Y-m-d H:i:s', time()),
                'dt_edition'    => date('Y-m-d H:i:s', time())
            ),
            array(
                'id'            => 1,
                'marca'         => 'Volkswagen',
                'modelo'        => 'Saveiro',
                'ano'           => 1987,
                'dt_creation'   => date('Y-m-d H:i:s', time()),
                'dt_edition'    => date('Y-m-d H:i:s', time())
            ),
            array(
                'id'            => 2,
                'marca'         => 'Fiat',
                'modelo'        => 'Uno',
                'ano'           => 1983,
                'dt_creation'   => date('Y-m-d H:i:s', time()),
                'dt_edition'    => date('Y-m-d H:i:s', time())
            )
        );

        $aux_array_encoded = json_encode($aux_array);
        // Stores the array in the JSON file.
        file_put_contents('../public/json/carros.json', $aux_array_encoded);

        $json_response = json_encode(array(0 => "Hello, world!"));
        $response->getBody()->write($json_response);
        $response = $response->withHeader('Content-type', 'application/json');

        return $response;
    });

    // Retrieves all records.
    $app->get('/api/carros[/]', function (Request $request, Response $response, $args) {
        // Retrieves the JSON file.
        $json_response = file_get_contents('../public/json/carros.json');

        // If the file is not empty.
        if (!empty($json_response)) {
            @json_decode($json_response);

            // If the JSON file shows errors.
            if ((json_last_error() !== JSON_ERROR_NONE) && (json_last_error() > 0)) {
                $json_response = json_encode(array(0 => "Nenhum resultado encontrado."));

            // If the JSON file shows no errors.
            } elseif ((json_last_error() === JSON_ERROR_NONE) || (json_last_error() == 0)) {
                // If the JSON file has only {} or [], then it is empty.
                if (($json_response == '[]') || ($json_response == '{}')) {
                    $json_response = json_encode(array(0 => "Nenhum resultado encontrado."));
                }
            }
        } else {
            // If the JSON file is empty.
            $json_response = json_encode(array(0 => "Nenhum resultado encontrado."));
        }

        $response->getBody()->write($json_response);
        $response = $response->withHeader('Content-type', 'application/json');

        return $response;
    });

    // Retrieves all records.
    $app->get('/api/marcas[/]', function (Request $request, Response $response, $args) {
        // Retrieves the JSON file.
        $json_response = file_get_contents('../public/json/marcas.json');

        // If the file is not empty.
        if (!empty($json_response)) {
            @json_decode($json_response);

            // If the JSON file shows errors.
            if ((json_last_error() !== JSON_ERROR_NONE) && (json_last_error() > 0)) {
                $json_response = json_encode(array(0 => "Nenhum resultado encontrado."));

            // If the JSON file shows no errors.
            } elseif ((json_last_error() === JSON_ERROR_NONE) || (json_last_error() == 0)) {

                // If the JSON file has only {} or [], then it is empty.
                if (($json_response == '[]') || ($json_response == '{}')) {
                    $json_response = json_encode(array(0 => "Nenhum resultado encontrado."));
                }
            }

        // If the file is empty.
        } else {
            $json_response = json_encode(array(0 => "Nenhum resultado encontrado."));
        }

        $response->getBody()->write($json_response);
        $response = $response->withHeader('Content-type', 'application/json');

        return $response;
    });

    // Retrieves only one record.
    $app->get('/api/carros/{id}[/]', function (Request $request, Response $response, $args) {
        $found_id = false;
        $found_carro = false;

        // Retrieves the JSON file.
        $json_file = file_get_contents('../public/json/carros.json');
        $carros_array = json_decode($json_file, true);

        // If the file is not empty.
        if (!empty($json_file)) {
            @json_decode($json_file);

            // If the JSON file shows errors.
            if ((json_last_error() !== JSON_ERROR_NONE) && (json_last_error() > 0)) {
                $json_response = json_encode(array(0 => "Nenhum resultado encontrado."));

                $response->getBody()->write($json_response);
                $response = $response->withHeader('Content-type', 'application/json');
            
                return $response;
            }
        }

        $carro_array = array();

        $carro_id = -1;
        // If the index record received is valid.
        if (is_numeric($args['id'])) {
            $carro_id = $args['id'];

            // Traverses the array looking for a match to the index received.
            for ($carros_idx = 0; $carros_idx < count($carros_array); $carros_idx++) {
                if ($carros_array[$carros_idx]['id'] == $carro_id) {
                    $carro_array['id'] = $carros_array[$carros_idx]['id'];
                    $carro_array['marca'] = $carros_array[$carros_idx]['marca'];
                    $carro_array['modelo'] = $carros_array[$carros_idx]['modelo'];
                    $carro_array['ano'] = $carros_array[$carros_idx]['ano'];
                    break;
                }
            }

            // If the resulting array is empty.
            if (empty($carro_array)) {
                $carro_array = array(0 => "Nenhum resultado encontrado.");
            }

        // If the index record received is NOT valid.
        } else {
            $carro_array = array(0 => "Nenhum resultado encontrado.");
        }

        $json_response = json_encode($carro_array);
        $response->getBody()->write($json_response);
        $response = $response->withHeader('Content-type', 'application/json');

        return $response;
    });

    // Includes one record.
    $app->post('/api/carros[/]', function (Request $request, Response $response, $args) {
        // Retrieves the JSON file.
        $json_file = file_get_contents('../public/json/carros.json');
        $carros_array = json_decode($json_file, true);

        // If the file is not empty.
        if (!empty($json_file)) {
            @json_decode($json_file);

            // If the JSON file shows errors.
            if ((json_last_error() !== JSON_ERROR_NONE) && (json_last_error() > 0)) {
                $json_response = json_encode(array(0 => "Nenhum resultado encontrado."));

                $response->getBody()->write($json_response);
                $response = $response->withHeader('Content-type', 'application/json');
            
                return $response;
            }
        }

        $carro = (string) $request->getBody();
        $carro_array = json_decode($carro, true);

        $carro_array['marca'] = filter_var($carro_array['marca'], FILTER_SANITIZE_STRING);
        $carro_array['modelo'] = filter_var($carro_array['modelo'], FILTER_SANITIZE_STRING);
        $carro_array['ano'] = filter_var($carro_array['ano'], FILTER_SANITIZE_STRING);

        $counter = 0;
        if (!empty($carros_array)) {
            $last_key = array_key_last($carros_array);
            $counter = ($carros_array[$last_key]['id'] + 1);
        }

        // Prepare the new record to be stored.
        $post_array = array(
            'id'            => $counter,
            'marca'         => $carro_array['marca'],
            'modelo'        => $carro_array['modelo'],
            'ano'           => (integer) $carro_array['ano'],
            'dt_creation'   => date('Y-m-d H:i:s', time()),
            'dt_edition'    => date('Y-m-d H:i:s', time())
        );
        // Push the record to the end of the array of records.
        array_push($carros_array, $post_array);

        $carros_array_encoded = json_encode($carros_array);
        // Store the records in the JSON file.
        file_put_contents('json/carros.json', $carros_array_encoded);

        // Now, verify if the new record was really stored, checking the last record of the file.
        $carros_array = json_decode(file_get_contents('../public/json/carros.json'), true);
        $carros_counter = array_key_last($carros_array);

        $result_array = json_encode(array("0" => "Falha ao tentar incluir as informações."));
        if ($counter == ($carros_array[$carros_counter]['id'])) {
            $result_array = json_encode(array("0" => "Carro incluído com sucesso."));
        }

        $response->getBody()->write($result_array);
        $response = $response->withHeader('Content-type', 'application/json');

        return $response;
    });

    // Updates one record.
    $app->put('/api/carros/{id}', function (Request $request, Response $response, $args) {
        // Retrieves the JSON file.
        $json_file = file_get_contents('../public/json/carros.json');
        $carros_array = json_decode($json_file, true);

        // If the file is not empty.
        if (!empty($json_file)) {
            @json_decode($json_file);

            // If the JSON file shows errors.
            if ((json_last_error() !== JSON_ERROR_NONE) && (json_last_error() > 0)) {
                $json_response = json_encode(array(0 => "Nenhum resultado encontrado."));

                $response->getBody()->write($json_response);
                $response = $response->withHeader('Content-type', 'application/json');
            
                return $response;
            }
        }

        $carro = (string) $request->getBody();
        $carro_array = json_decode($carro, true);
        $marca = filter_var($carro_array['marca'], FILTER_SANITIZE_STRING);
        $modelo = filter_var($carro_array['modelo'], FILTER_SANITIZE_STRING);
        $ano = filter_var($carro_array['ano'], FILTER_SANITIZE_STRING);

        $temp_array = array();
        $carro_array = array();
        $carro_id = -1;
        $found_id = -1;

        // If the index record received is valid.
        if (is_numeric($args['id'])) {
            $carro_id = $args['id'];

            // Traverses the array looking for a match to the index received.
            for ($carros_idx = 0; $carros_idx < count($carros_array); $carros_idx++) {
                // If a match is found, the contents of the record are updated.
                if ($carros_array[$carros_idx]['id'] == $carro_id) {
                    $carro_array['id'] = $carros_array[$carros_idx]['id'];
                    $found_id = $carros_idx;
                    $carro_array['marca'] = $marca;
                    $carro_array['modelo'] = $modelo;
                    $carro_array['ano'] = $ano;
                    $carro_array['dt_creation'] = $carros_array[$carros_idx]['dt_creation'];
                    $carro_array['dt_edition'] = date('Y-m-d H:i:s', time());

                // If a match is NOT found, the contents of the record are kept.
                } else {
                    $carro_array['id'] = $carros_array[$carros_idx]['id'];
                    $carro_array['marca'] = $carros_array[$carros_idx]['marca'];
                    $carro_array['modelo'] = $carros_array[$carros_idx]['modelo'];
                    $carro_array['ano'] = $carros_array[$carros_idx]['ano'];
                    $carro_array['dt_creation'] = $carros_array[$carros_idx]['dt_creation'];
                    $carro_array['dt_edition'] = $carros_array[$carros_idx]['dt_edition'];
                }
                array_push($temp_array, $carro_array);
            }
            $carros_array_encoded = json_encode($temp_array);
            file_put_contents('../public/json/carros.json', $carros_array_encoded);

            $result_array = json_encode(array("0" => "Falha ao tentar modificar as informações."));
            if ($carro_id > -1) {
                $carros_array = json_decode(file_get_contents('../public/json/carros.json'), true);

                if (($carros_array[$found_id]['id'] == $carro_id) &&
                    ($carros_array[$found_id]['marca'] == $marca) &&
                    ($carros_array[$found_id]['modelo'] == $modelo) &&
                    ($carros_array[$found_id]['ano'] == $ano)
                ) {
                    $result_array = json_encode(array("0" => "Informações modificadas com sucesso."));
                }
            }

        // If the index record received is NOT valid.
        } else {
            $carro_array = array(0 => "Nenhum resultado encontrado.");
        }

        $response->getBody()->write($result_array);
        $response = $response->withHeader('Content-type', 'application/json');

        return $response;
    });

    // Excludes one record.
    $app->delete('/api/carros/{id}', function (Request $request, Response $response, $args) {
        // Retrieves the JSON file.
        $json_file = file_get_contents('../public/json/carros.json');
        $carros_array = json_decode($json_file, true);

        // If the file is not empty.
        if (!empty($json_file)) {
            @json_decode($json_file);

            // If the JSON file shows errors.
            if ((json_last_error() !== JSON_ERROR_NONE) && (json_last_error() > 0)) {
                $json_response = json_encode(array(0 => "Nenhum resultado encontrado."));

                $response->getBody()->write($json_response);
                $response = $response->withHeader('Content-type', 'application/json');
            
                return $response;
            }
        }

        $temp_array = array();
        $carro_array = array();
        $carro_id = -1;

        // If the index record received is valid.
        if (is_numeric($args['id'])) {
            $carro_id = $args['id'];

            // Traverses the array looking for a match to the index received.
            for ($carros_idx = 0; $carros_idx < count($carros_array); $carros_idx++) {
                // If a match is NOT found, the contents of the record are kept.
                if ($carros_array[$carros_idx]['id'] != $carro_id) {
                    $carro_array['id'] = $carros_array[$carros_idx]['id'];
                    $carro_array['marca'] = $carros_array[$carros_idx]['marca'];
                    $carro_array['modelo'] = $carros_array[$carros_idx]['modelo'];
                    $carro_array['ano'] = $carros_array[$carros_idx]['ano'];
                    $carro_array['dt_creation'] = $carros_array[$carros_idx]['dt_creation'];
                    $carro_array['dt_edition'] = $carros_array[$carros_idx]['dt_edition'];
                    array_push($temp_array, $carro_array);
                }
            }

        // If the index record received is NOT valid.
        } else {
            $carro_array = array(0 => "Nenhum resultado encontrado.");
        }

        $carros_array_encoded = json_encode($temp_array);
        file_put_contents('../public/json/carros.json', $carros_array_encoded);

        // Now, verify if the new record was really excluded.
        $carros_array = json_decode(file_get_contents('../public/json/carros.json'), true);

        $found_id = false;
        $result_array = json_encode(array("0" => "Falha ao tentar excluir as informações. " . $carro_id));
        if ($carro_id > -1) {
            // Traverses the array looking for a match to the index received.
            for ($carros_idx = 0; $carros_idx < count($carros_array); $carros_idx++) {
                // If a match is NOT found, the contents of the record are kept.
                if ($carros_array[$carros_idx]['id'] == $carro_id) {
                    $found_id = true;
                }

                if (($found_id === true) || ($carros_idx >= $carro_id)) {
                    break;
                }
            }

            if ($found_id === false) {
                $result_array = json_encode(array("0" => "Informações excluídas com sucesso."));
            }
        }

        $response->getBody()->write($result_array);
        $response = $response->withHeader('Content-type', 'application/json');

        return $response;
    });

    $app->get('/', function (Request $request, Response $response, $args) {
        $response_string = '
        <!DOCTYPE HTML>
        <html lang="pt-br">
        <head>
            <meta charset="UTF-8">
            <title>Carros & Carros</title>  
            <link rel="stylesheet" type="text/css" href="css/carros.css">
            <link rel="shortcut icon" href="images/favicon.ico" />
            <script src="js/carros.js"></script>
        </head>

        <body>
            <form action="" enctype="application/json" method="post">
                <div style="max-width: 800px; width: 100%; margin: auto;">
                    <button type="button" class="button" onclick="listAll()">Cadastrados</button>
                    <button type="button" class="button include" onclick="includeOne()">Cadastrar</button>
                    <br/>&nbsp;
                    <div id="carros_msg">Pressione algum dos bot&otilde;es acima.</div><br/>
                </div>

                <div id="carros_op"></div>
            </form>
        </body>
        </html>';

        $response->getBody()->write($response_string);
        return $response;
    });
};
