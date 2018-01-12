<?php
/*
 * Esse arquivo contem as informacoes extras para obter os dados da tabela fipe e os dados das imagens do carro
 * */

/*Montei um sistema de GET simples para obter as informacoes*/
if (isset($_GET['img'])) {
    /*pego o meu leitor de html padrao o simple html dom facil de usar e muito util*/
    include "simple_html_dom/simple_html_dom.php";
    /*pego a query que foi enviada via GET*/
    $search_query = $_GET['img'];
    /*Codifico para uma query de url caso nao esteja*/
    $search_query = urlencode($search_query);
    /*pego a pagina do google com a query em si*/
    $html = file_get_html("https://www.google.com/search?q=$search_query&tbm=isch");
    /*Comeco "quebrando" a pagina*/
    $image_container = $html->find('div#ires', 0);
    /*pego o local onde as imagens estao no caso a primeira imagem apenas*/
    $image_containertable = $image_container->find('td', 0);
    /*pego todoas as imagens dentro do item acima*/
    $images = $image_containertable->find('img');
    /*Quantas imagens eu tenho que buscar*/
    $image_count = 1;
    $i = 0;
    foreach ($images as $image) {
        if ($i == $image_count) break;
        $i++;
        /*mostro apenas a url da imagem*/
        echo $image->src;
    }

    /*Aqui faço a busca pelas marcas para alimentar os select Box*/
} elseif (isset($_GET['marca']) && !is_numeric($_GET['marca'])) {
    $apiurl = 'https://fipe.parallelum.com.br/api/v1/carros/marcas'; #url para obter todos as marcas
    $marcas = json_decode(file_get_contents($apiurl), true); #transformo o json obtido em array
    foreach ($marcas as $marca) { #passo por todos as marcas ate encontrar alguma que mais se coincide com o valor digitado
        if (stristr($_GET['marca'], $marca['nome'])) {
            $result = $marca['codigo']; #Mostro o codigo da marca obitido
        }
    }
    if (!isset($result)) { #caso nenhum modelo tenha vindo eu mando toda a lista
        $result = json_encode($marcas, JSON_PRETTY_PRINT);
    }
    print_r($result);

    /*Aqui faco a busca pelos modelos apartir da marca*/
} elseif (isset($_GET['model']) && is_numeric($_GET['marca']) && !isset($_GET['ano'])) {
    $apiurl = 'https://fipe.parallelum.com.br/api/v1/carros/marcas/' . $_GET['marca'] . '/modelos'; #url para obter todos os modelos dessa marca
    $models = json_decode(file_get_contents($apiurl), true);  #transformo o json obtido em array
    foreach ($models['modelos'] as $model) { #passo por todos os modelos ate encontrar algum que mais se coincide com o valor digitado
        if (stristr($_GET['model'], $model['nome'])) {
            $result = $model['codigo']; #Mostro o codigo do modelo obitido
        }
    }
    if (!isset($result)) {#caso nenhuma marca tenha vindo eu mando toda a lista
        $result = json_encode($models, JSON_PRETTY_PRINT);
    }
    print_r($result);
    /*Aqui faco a busca dos anos apartir do modelo e da marca*/
} elseif (is_numeric($_GET['model']) && is_numeric($_GET['marca']) && empty($_GET['ano'])) {
    $apiurl = 'https://fipe.parallelum.com.br/api/v1/carros/marcas/' . $_GET['marca'] . '/modelos/' . $_GET['model'] . '/anos'; #url para obter todos os anos dessa marca e modelo
    $anos = json_decode(file_get_contents($apiurl), true); #transformo o json obtido em array
    echo json_encode($anos, JSON_PRETTY_PRINT);  #Mostro os anos do modelo obitidos
    /*aqui obtenho todos os dados dos carro apartir do modelo da marca e do ano*/
} elseif (isset($_GET['ano']) && is_numeric($_GET['model']) && is_numeric($_GET['marca']) && !empty($_GET['ano'])) {
    $apiurl = 'https://fipe.parallelum.com.br/api/v1/carros/marcas/' . $_GET['marca'] . '/modelos/' . $_GET['model'] . '/anos/' . $_GET['ano'];#url para obter todos os dados do carro dessa marca e modelo e ano
    $header = get_headers($apiurl);
    if ('HTTP/1.1 404 Not Found' != $header[0]) {
        $anos = json_decode(file_get_contents($apiurl), true); #transformo o json obtido em array
        echo json_encode($anos, JSON_PRETTY_PRINT);#Mostro os anos do modelo obitidos
    } else {
        echo '{
    "Valor": "Não encontrado",
    "Combustivel": "Não encontrado",
    "CodigoFipe": "Não encontrado",
    "MesReferencia": "Não encontrado",
    "TipoVeiculo": "Não encontrado",
    "SiglaCombustivel": "Não encontrado"
    }';
    }

}