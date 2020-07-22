<?php

$conexao = fopen("banco.json", "rb");
$conteudodoBanco = stream_get_contents($conexao);
fclose($conexao);

if(!$resultado = json_decode($conteudodoBanco, true)){    
    
    $resultado[] = [
            'id'            => 0,
            'modelo'        => 'verificacao',
            'marca'         => 'verificacao',
            'ano'           => 'verificacao',
            'validation'    => true
    ];

    $carro = json_encode($resultado);
    $conexao = fopen("banco.json", "a");

    if(!fwrite($conexao, $carro)){     
        $resultado[] = [
            'id'            => 0,
            'modelo'        => 'Error 0:    Não foi possível conectar com o servidor!',
            'marca'         => '',
            'ano'           => '',
            'validation'    => false
        ];     
    }    
}

echo json_encode($resultado);
exit();

?>