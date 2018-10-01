<?php
//session_start();
require ('queriesclass.php');


$ConsultaUsuario = new ConsultasMysql();

$ConsultaUsuario->marca = 'Ford';
$ConsultaUsuario->modelo = 'fiesta';
$ConsultaUsuario->ano = '2013';



$result = $ConsultaUsuario->InsertQuery($ConsultaUsuario->marca,$modelo->idade,$ano->games);
//$mysqli->query($result);

$result = $ConsultaUsuario->Updatequery('Games',$ConsultaUsuario->games,2);
//$mysqli->query($result);

$result = $mysqli->query($ConsultaUsuario->SelectQuery($ConsultaUsuario->marca,$modelo->idade,$ano->games));

if ($result->num_rows > 0) {
    
    while($row = $result->fetch_assoc()) {
      
         $encode[] = $row;
        
    }
} else {
    $encode = "nada";
}
//$mysqli->close();
echo json_encode($encode);
?>