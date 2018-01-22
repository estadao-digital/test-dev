<?php
require 'vendor/autoload.php';
use Slim\App;
use Slim\Http\Request;

$app = new App();
$app->get('/cars', 'getCars');
$app->get('/cars/:id', 'getCar');
$app->post('/cars', 'addCar');
$app->put('/cars/:id/edit', 'updateCar');
$app->delete('/cars/:id', 'deleteCar');

$app->run();

function getCars() {
    $sql = "select * FROM cars ORDER BY id";
    try {
        $db = getConnection();
        $stmt = $db->query($sql);  
        $cars = $stmt->fetchAll(PDO::FETCH_OBJ);
        $db = null;
        echo json_encode($cars);
    } catch(PDOException $e) {
        echo '{"error":{"text":'. $e->getMessage() .'}}'; 
    }
}

function getCar($id) {
    echo "teste aqui";die();
    $sql = "select * FROM cars WHERE id=".$id." ORDER BY id";
    try {
        $db = getConnection();
        $stmt = $db->query($sql);  
        $cars = $stmt->fetchAll(PDO::FETCH_OBJ);
        $db = null;
        echo json_encode($cars);
    } catch(PDOException $e) {
        echo '{"error":{"text":'. $e->getMessage() .'}}'; 
    }
}

function addCar(Request $request) {
    $car = json_decode($request->getBody());
    $sql = "INSERT INTO cars (brand, model, year) VALUES (:brand, :model, :year)";
    try {
        $db = getConnection();
        $stmt = $db->prepare($sql);  
        $stmt->bindParam("brand", $car->brand);
        $stmt->bindParam("model", $car->model);
        $stmt->bindParam("year", $car->year);
        $stmt->execute();
        $car->id = $db->lastInsertId();
        $db = null;
        echo json_encode($car); 
    } catch(PDOException $e) {
        echo '{"error":{"text":'. $e->getMessage() .'}}'; 
    }
}

function updateCar(Request $request, $id) {
    $car = json_decode($request->getBody());
    $sql = "UPDATE cars SET brand=:brand, model=:model, year=:year WHERE id=:id";
    try {
        $db = getConnection();
        $stmt = $db->prepare($sql);  
        $stmt->bindParam("brand", $car->brand);
        $stmt->bindParam("model", $car->model);
        $stmt->bindParam("year", $car->year);
        $stmt->bindParam("id", $id);
        $stmt->execute();
        $db = null;
        echo json_encode($car); 
    } catch(PDOException $e) {
        echo '{"error":{"text":"'. $e->getMessage() .'"}}';
    }
}

function deleteCar($id) {
    $sql = "DELETE FROM cars WHERE id=".$id;
    try {
            $db = getConnection();
            $stmt = $db->query($sql);  
            $wines = $stmt->fetchAll(PDO::FETCH_OBJ);
            $db = null;
            echo json_encode($wines);
    } catch(PDOException $e) {
            echo '{"error":{"text":'. $e->getMessage() .'}}'; 
    }
}

function getConnection() {
    $dbhost="127.0.0.1";
    $dbuser="root";
    $dbpass="root";
    $dbname="test-dev-db";
    $dbh = new PDO("mysql:host=$dbhost;dbname=$dbname", $dbuser, $dbpass);	
    $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    return $dbh;
}