<?php


function lerTxT()
{
    $marcas = array();

    // Abre o Arquvio no Modo r (para leitura)
    $arquivo = fopen('dados/marca.txt', 'r');
    if ($arquivo) {
        while (!feof($arquivo)) {

            //Mostra uma linha do arquivo
            $marca = new stdClass();
            $linha = fgets($arquivo, 1024);
            if (empty($linha) || $linha === "\n") {

            } else {
                $marca->marca = $linha;
                $marcas[] = $marca;
            }
        }
        fclose($arquivo);
    }

    return $marcas;
}

function lerTxTTeste()
{
    $marcas = array();

    // Abre o Arquvio no Modo r (para leitura)
    $arquivo = fopen('dados/marca.txt', 'r');
    if ($arquivo) {
        while (!feof($arquivo)) {
            //Mostra uma linha do arquivo
            $linha = fgets($arquivo, 1024);
            echo $linha;
            echo "<br>";

        }
        fclose($arquivo);
    }

    return $marcas;
}


function cadastrar($dados)
{

    $file = fopen("dados/marca.txt", "a+");
    fwrite($file, $dados);
    if ($file == false) {
        fclose($file);
        return false;
    } else {
        fclose($file);
        return true;
    }

}

function removerMarca($marcaRemove)
{
    $txt = file("dados/marca.txt");
    $resultado = 0;
    foreach ($txt as $k => $linha) {
        if (empty($linha) && $linha === "\n") {

        } else {
            try {

                if (!empty($linha)) {
                    $marca = str_replace(" ","_",preg_replace("/&([a-z])[a-z]+;/i", "$1", htmlentities(trim($linha))));
                    $marcaRM = str_replace(" ","_",preg_replace("/&([a-z])[a-z]+;/i", "$1", htmlentities(trim($marcaRemove))));
                    if ($marca === $marcaRM) {
                        unset($txt[$k]);
                        $resultado++;
                    }
                }
            } catch (Exception $ex) {
                print_r($ex->getMessage());
            }
        }
    }
    file_put_contents('dados/marca.txt', $txt);
    return $resultado;

}

?>