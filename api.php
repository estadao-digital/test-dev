<?php session_start();
require ('Carro.class.php');

$pdfp = fopen('php://input', 'r');
$pddata = '';
while($data = fread($pdfp, 1024))
    $pddata .= $data;
fclose($pdfp);
parse_str($pddata, $_REQUEST2);

$return = array();
$obj = new Carro();

if ((isset($_REQUEST['instancia']) && $_REQUEST['instancia']=='carros') || 
    (isset($_REQUEST2['instancia']) && $_REQUEST2['instancia']=='carros')) {

  switch ($_SERVER['REQUEST_METHOD']) {
    case 'GET':
      if (isset($_GET['id']) && !empty($_GET['id'])) {
        $id = (int) $_GET['id'];
        $return = $obj->getCarro($id);
      } else {
        $return = $_SESSION['carros'] = $obj->getCarros();
      }
      break;
    case 'POST':
      $nId = (end($_SESSION['carros'][0])+1);
      array_push($_SESSION['carros'][0], $nId);
      array_push($_SESSION['carros'][1], $_POST);
      $obj->setCarros($_SESSION['carros']);
      $return = array('success'=>'Cadastro realizado com sucesso!');
      break;
    case 'PUT':
      if (isset($_REQUEST2['id'])) {
        $id = (int) $_REQUEST2['id'];
        if (isset($_SESSION['carros'][0])) {
          $search = array_search($id, $_SESSION['carros'][0]);
          $_SESSION['carros'][1][$search]['marca'] = $_REQUEST2['marca'];
          $_SESSION['carros'][1][$search]['modelo'] = $_REQUEST2['modelo'];
          $_SESSION['carros'][1][$search]['ano'] = $_REQUEST2['ano'];
          $obj->setCarros($_SESSION['carros']);
          $return = array('success'=>'Cadastro atualizado com sucesso!');
        } else {
          $return = array('error'=>'O cadastro que você está tentando atualizar não exite!');
        }
      } else {
        $return = array('error'=>'Informe um id para realizar a operação!');
      }
      break;
    case 'DELETE':
      if (isset($_REQUEST2['id'])) {
        $id = (int) $_REQUEST2['id'];
        if (isset($_SESSION['carros'][$id])) {
          unset($_SESSION['carros'][$id]);
          $obj->setCarros($_SESSION['carros']);
          $return = array('success'=>'Cadastro(s) apagado(s) com sucesso!');
        } else {
          $return = array('error'=>'O(s) cadastro(s) que você está tentando apagar não exite(m)!');
        }
      } else {
        $return = array('error'=>'Informe um id para realizar a operação!');
      }
      break;
    default:
      $return = array('error'=>'Transação não permitida!');
  }

} else if ((isset($_REQUEST['instancia']) && $_REQUEST['instancia']=='marcas') || 
           (isset($_REQUEST2['instancia']) && $_REQUEST2['instancia']=='marcas')) {
  
  switch ($_SERVER['REQUEST_METHOD']) {
    case 'GET':
      $return = $obj->getMarcas();
      break;
    default:
      $return = array('error'=>'Transação não permitida!');
  }

} else {

  $return = array('error'=>'Ação não permitida!');

}

$str_json = json_encode($return);
$json_response = preg_replace_callback('/\\\\u([0-9a-f]{4})/i', array($obj, 'json_unescaped_unicode'), $str_json);
echo $json_response;

?>
