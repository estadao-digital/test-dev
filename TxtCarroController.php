<?php


function lerTxT()
{
    $carros = array();

    // Abre o Arquvio no Modo r (para leitura)
    $arquivo = fopen('dados/bd.txt', 'r');
    if ($arquivo) {
        while (!feof($arquivo)) {
            //Mostra uma linha do arquivo
            $carro = new stdClass();
            $linha = fgets($arquivo, 1024);

            if (empty($linha) || $linha === "\n") {

            } else {
                //echo $linha;
                $dados = explode("&", $linha);

                foreach ($dados as $item) {
                    $i = explode("=", $item);
                    if ($i[0] === "modelo") {
                        $carro->modelo = $i[1];
                    } else if ($i[0] === "ano") {
                        $carro->ano = $i[1];
                    } else if ($i[0] === "marca") {
                        $carro->marca = $i[1];
                    } else if ($i[0] === "id") {
                        $carro->id = $i[1];
                    }

                }
                $carros[] = $carro;
            }

        }
        fclose($arquivo);
    }

    return $carros;
}


function cadastrar($dados)
{

    $file = fopen("dados/bd.txt", "a+");
    fwrite($file, $dados);
    if ($file == false) {
        fclose($file);
        return false;
    } else {
        fclose($file);
        return true;
    }

}

function buscarCarroID($carroID)
{
    try {
        $txt = file("dados/bd.txt");
        $resultado = 0;
        foreach ($txt as $k => $linha) {
            if (empty($linha) || $linha === "\n") {

            } else {
                $carro = new stdClass();
                $dados = explode("&", $linha);
                $id = explode("=", $dados[0]);
                if ($id[1] === $carroID) {
                    $dados = explode("&", $linha);

                    //salva os dados no objeto
                    foreach ($dados as $item) {
                        $i = explode("=", $item);
                        if ($i[0] === "modelo") {
                            $carro->modelo = $i[1];
                        } else if ($i[0] === "ano") {
                            $carro->ano = $i[1];
                        } else if ($i[0] === "marca") {
                            $carro->marca = $i[1];
                        } else if ($i[0] === "id") {
                            $carro->id = $i[1];
                        }

                    }

                    return $carro;
                }
            }
        }
        return 0;
    } catch (Exception $ex) {
        return 0;
    }

}

function removerCarro($idRemove)
{
    try {
        $txt = file("dados/bd.txt");
        $resultado = 0;
        foreach ($txt as $k => $linha) {
            if (empty($linha) || $linha === "\n") {

            } else {
                $dados = explode("&", $linha);
                $id = explode("=", $dados[0]);
                if ($id[1] === $idRemove) {
                    unset($txt[$k]);
                    $resultado++;
                }
            }
        }
        file_put_contents('dados/bd.txt', $txt);
        if (!empty($resultado)) {
            return $resultado;
        } else {
            return $resultado;
        }
    } catch (Exception $ex) {
        return 0;
    }

}

function alterarCarro($dadosAlterados)
{

    try {
        //pegar o ID para comparar com as linhas carregadas do arquivo.
        $parametros = explode("&", $dadosAlterados);
        $parametrosExploded = explode("=", $parametros[0]);

        $idAlterar = $parametrosExploded[1];

        $txt = file("dados/bd.txt");
        $resultado = 0;
        foreach ($txt as $k => $linha) {
            if (empty($linha) || $linha === "\n") {

            } else {
                $dados = explode("&", $linha);
                $id = explode("=", $dados[0]);
                if ($id[1] === $idAlterar) {

                    $txt[$k] = $dadosAlterados."\n";
                    $resultado++;
                }
            }
        }
        file_put_contents('dados/bd.txt', $txt);
        if (!empty($resultado)) {
            return $resultado;
        } else {
            return $resultado;
        }
    } catch (Exception $ex) {
        return 0;
    }

}

?>