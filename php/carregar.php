<?php
$id = $_POST['id'];
$acao = $_POST['acao'];
$modelo = $_POST['modelo'];
$marca = $_POST['marca'];
$ano = $_POST['ano'];

//Limpando caracteres que poderiam causar efeitos adversos no sistema.
$modelo = str_replace('"', '', $modelo);
$marca = str_replace('"', '', $marca);
$ano = str_replace('"', '', $ano);
$modelo = str_replace('&', '', $modelo);
$marca = str_replace('&', '', $marca);
$ano = str_replace('&', '', $ano);
$modelo = str_replace('\\', '', $modelo);
$marca = str_replace('\\', '', $marca);
$ano = str_replace('\\', '', $ano);

function VerificacaoDeErros( $modelo, $marca, $ano){
    $modelo = str_replace(' ', '', $modelo);
    $marca = str_replace(' ', '', $marca);
    $ano = str_replace(' ', '', $ano);
    if(!empty($modelo) && $modelo != ''){
        if(!empty($marca) && $marca != ''){
            if(!empty($ano) && $ano != ''){
                if($ano > 1899 && $ano < 2021){
                    $verificado = "ok";
                }else{
                    $verificado = "Error 3:     Só é permitido dos anos 1900 à 2020!";
                }                
            }else{
                $verificado = "Error 3:    Não foi especificado o ano do modelo!";
            }
        }else{
            $verificado = "Error 3:    Não foi selecionado a marca!";
        }
    }else{
        $verificado = "Error 3:    Não foi especificado o nome do modelo!";
    }
    return $verificado;
}

if($acao == "carregar" && $id == "0"){
    include(__DIR__.'/acessarbanco.php'); 
}elseif($acao == "criar"){
    include(__DIR__.'/cadastrar.php'); 
}elseif($acao == "editar"){
    include(__DIR__.'/editar.php'); 
}elseif($acao == "excluir"){
    include(__DIR__.'/excluir.php'); 
}else{
    $DadosBancoArray = array();
    $DadosBancoArray[] = [
        'id'   => 0,
        'modelo'     => '',
        'marca' => '',
        'ano' => '',
        'validation' => ''
    ];        
    echo json_encode($DadosBancoArray);
    exit();
}
?>