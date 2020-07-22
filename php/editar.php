<?php
// EDITAR 
$conexao = file_get_contents('banco.json');

if( $conteudo = json_decode($conexao, true) ){

    $verificar = VerificacaoDeErros($modelo,$marca,$ano);
    
    if( $verificar  ==  "ok"    ){
        
        foreach (   $conteudo as $key => $value) {
            if ($value['id'] == $id) {
                $conteudo[$key]['modelo'] = $modelo;
                $conteudo[$key]['marca'] = $marca;
                $conteudo[$key]['ano'] = $ano;
            }
        }

        $conteudo = json_encode($conteudo);

        if(  file_put_contents('banco.json', $conteudo)  ){ 

            $resultado[] = [
                'id'            => $id,
                'modelo'        => $modelo,
                'marca'         => $marca,
                'ano'           => $ano,
                'validation'    => true
            ];

        }else{   

            $resultado[] = [
                'id'            => 0,
                'modelo'        => 'Error 1:    Não foi possível concluir a alteração!',
                'marca'         => '',
                'ano'           => '',
                'validation'    => false
            ];

        }

    }else{   

        $resultado[] = [
            'id'            => 0,
            'modelo'        => $verificar,
            'marca'         => '',
            'ano'           => '',
            'validation'    => false
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