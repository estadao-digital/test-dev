<?php
//EXCLUIR
$conexao = file_get_contents('banco.json');

if($conteudo = json_decode($conexao, true)){

    $filtro = array();

    foreach ($conteudo as $key => $value) {

        if ($value['id'] == $id) {
            $filtro[] = $key;
        }

    }

    foreach ($filtro as $i) {
        unset($conteudo[$i]);
    }

    $conteudo = array_values($conteudo);
    $conteudo = json_encode($conteudo);

    if(file_put_contents('banco.json', $conteudo)){
        
        $resultado[] = [
            'id'            => $id,
            'modelo'        => 'exclua',
            'marca'         => '',
            'ano'           => '',
            'validation'    => true
        ];

    }else{

        $resultado[] = [
            'id'            => 0,
            'modelo'        => 'Error 1:    Não foi possível excluir!',
            'marca'         => '',
            'ano'           => '',
            'validation'    => ''
        ];

    }

}else{

    $resultado[] = [
        'id'            => 0,
        'modelo'        => 'Error 0:    Não foi possível conectar com o servidor!',
        'marca'         => '',
        'ano'           => '',
        'validation'    => false
    ];

}

echo json_encode($resultado);
exit();
?>