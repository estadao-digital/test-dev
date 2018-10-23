<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

// include database and object files
include_once './config/JsonDatabase.php';
include_once './objects/Carro.php';
include_once './objects/CarroDTO.php';
include_once './objects/Marca.php';
include_once './objects/MarcaDTO.php';

$arr = explode('/', $_SERVER['REQUEST_URI']);

$action = $arr[3];
$id = end($arr);

switch($action) {
    case 'carros' : {
        // inicializando objeto
        $carro = new Carro();
        $carroDTO = new CarroDTO();

        switch ($_SERVER['REQUEST_METHOD']) {
            case 'POST': {
                //cadastrar um novo
                $_POST = file_get_contents('php://input');
                $_POST = json_decode($_POST, true);

                // check if more than 0 record found
                try {
                    $carro->setMarca($_POST['marca']);
                    $carro->setModelo($_POST['modelo']);
                    $carro->setAno($_POST['ano']);

                    $carroDTO->setCarro($carro);
                    $carros = $carroDTO->add();

                    // set response code - 200 OK
                    http_response_code(200);

                    // show products data in json format
                    echo json_encode($carros);
                } catch (Exception $e) {
                    // set response code - 404 Not found
                    http_response_code(404);

                    // tell the user no products found
                    echo json_encode(
                        array("message" => "Não há nenhum carro cadastrado.")
                    );
                }
            }
                break;
            case 'GET': {
                if ($id != '') {
                    try {
                        //retornar um ID específico
                        $carro = $carroDTO->getDataById($id);
                        if($carro == false) {
                            // set response code - 404 Not found
                            http_response_code(404);
                        }
                        // set response code - 200 OK
                        http_response_code(200);

                        echo json_encode($carro);
                    } catch (Exception $e) {
                        // set response code - 404 Not found
                        http_response_code(404);
                    }
                } else {
                    //retornar todos
                    try {
                        $get = file_get_contents('php://input');

                        $carroDTO->setCarro($carro);
                        $carro = $carroDTO->getMappedData();

                        // set response code - 200 OK
                        http_response_code(200);

                        // show products data in json format
                        echo json_encode($carro);
                    } catch (Exception $e) {

                        // set response code - 404 Not found
                        http_response_code(404);

                        // tell the user no products found
                        echo json_encode(
                            array("message" => "Não há nenhum carro cadastrado.")
                        );
                    }
                }
            }
                break;
            case 'PUT': {
                try {
                    //atualizar os dados
                    $put = file_get_contents('php://input');
                    $put = json_decode($put, true);


                    unset($put["editMode"]);
                    $carros = $carroDTO->updateData($id, $put);

                    // set response code - 200 OK
                    http_response_code(200);

                    // show products data in json format
                    echo json_encode($carros);
                } catch (Exception $e) {

                    // set response code - 404 Not found
                    http_response_code(404);

                    // tell the user no products found
                    echo json_encode(
                        array("message" => "Não há nenhum carro cadastrado.")
                    );
                }
            }
                break;
            case 'DELETE': {
                //deletar os dados
                try {
                    $carros = $carroDTO->deleteData($id);

                    // set response code - 200 OK
                    http_response_code(200);

                    // show products data in json format
                    echo json_encode($carros);
                } catch (Exception $e) {

                    // set response code - 404 Not found
                    http_response_code(404);

                    // tell the user no products found
                    echo json_encode(
                        array("message" => "Não há nenhum ID carro para excluir.")
                    );
                }
            }
        }
    }
    break;
    case 'marcas' : {
        // inicializando objeto
        $marcaDTO = new MarcaDTO();

        //retornar todos
        try {
            $get = file_get_contents('php://input');

            $marca = $marcaDTO->getData();
            // set response code - 200 OK
            http_response_code(200);

            // show products data in json format
            echo json_encode($marca);
        } catch (Exception $e) {

            // set response code - 404 Not found
            http_response_code(404);

            // tell the user no products found
            echo json_encode(
                array("message" => "Não há nenhum carro cadastrado.")
            );
        }

    }
}
?>