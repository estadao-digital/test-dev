<?php

$conexao = fopen("banco.json", "rb");
$conteudoBanco = stream_get_contents($conexao);
fclose($conexao);

if($conteudoBanco = json_decode($conteudoBanco, true)){

    $laço = 0;
    $novoId = 0;
    $verificar = VerificacaoDeErros($modelo,$marca,$ano);

    if($verificar == "ok"){

        while($laço < count($conteudoBanco)){

            if($conteudoBanco[$laço]['id']>$novoId){
                $novoId = $conteudoBanco[$laço]['id'];
            }

            $laço++; 

        }

        $conteudoBanco[$laço] = [
            'id'            => $novoId+1,
            'modelo'        => $modelo,
            'marca'         => $marca,
            'ano'           => $ano,
            'validation'    => true
        ];

        $carro = json_encode($conteudoBanco);
        $conexao = fopen('banco.json','w');

        if(!fwrite($conexao, $carro)){ 

            $resultado[] = [
                'id'            => 0,
                'modelo'        => 'Error 1:    Não foi possível concluir o cadastro!',
                'marca'         => '',
                'ano'           => '',
                'validation'    => false
            ];

        }else{
            $resultado[] = $conteudoBanco[$laço];
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