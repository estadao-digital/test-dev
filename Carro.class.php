<?php
require_once "conexao.php";   
require_once "carro.model.php";
$carros = crudCarro::getInstance(Conexao::getInstance());
header('Content-type: text/html; charset=utf-8');


if (isset($_POST)){
    $marca    = (isset($_POST['marca']))? $_POST['marca']: '';
    $modelo   = (isset($_POST['modelo']))? $_POST['modelo']: '';
    $ano = (isset($_POST['ano']))? $_POST['ano']: '';
    $id     = (isset($_POST['id']))? $_POST['id']: '';
    $status     = (isset($_POST['status']))? $_POST['status']: '';

echo $id;

}   

 


         // aqui é onde faz o delete
if($status == 2){
    $carros->delete($id);

    //faz o select e insere no arquivo json
   unlink('teste.json'); // apaga o arquivo Json
   $dados = $carros->getAllCarros();

   
// abre o ficheiro em modo de escrita
$fp = fopen('teste.json', 'w');

// escreve no ficheiro em json
fwrite($fp, json_encode($dados));
// fecha o ficheiro
fclose($fp);
        


}else if($status == 1) {



    // aqui é onde adiciona no banco

   
   $carros->insert($modelo, $marca, $ano);


   //faz o select e insere no arquivo json
   unlink('teste.json'); // apaga o arquivo Json
   $dados = $carros->getAllCarros();

   
// abre o ficheiro em modo de escrita
$fp = fopen('teste.json', 'w');

// escreve no ficheiro em json
fwrite($fp, json_encode($dados));
// fecha o ficheiro
fclose($fp);
       


}else{



    // aqui é onde faz o update

   
   $carros->update($modelo, $marca, $ano,$id);


   //faz o select e insere no arquivo json
   unlink('teste.json'); // apaga o arquivo Json
   $dados = $carros->getAllCarros();

   
// abre o ficheiro em modo de escrita
$fp = fopen('teste.json', 'w');

// escreve no ficheiro em json
fwrite($fp, json_encode($dados));
// fecha o ficheiro
fclose($fp);
         
}      

Class selectCarros{
    
    public function select($id){
        require_once "conexao.php";   
    require_once "carro.model.php";

    $carros = crudCarro::getInstance(Conexao::getInstance());
    
        $dados = $carros->selectCarros($id);
        
        return $dados;

    }

}



 

       