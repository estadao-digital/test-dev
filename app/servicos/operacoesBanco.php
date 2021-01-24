<?php
    $localBanco = 'banco';

    function pegaTuplaPorId(String $nomeTabela, int $id)
    {
        $lista = pegaTabela($nomeTabela);
        foreach($lista as $objeto) {
            if ($objeto['id'] == $id){
                return $objeto;
            }
        }
  
        return Array();
    }
  
    function pegaTabela (String $nomeTabela) {
        $lista_json = file_get_contents(pegaArquivoTabela( $nomeTabela));
        return json_decode($lista_json, true);
    }
  
    function pegaArquivoTabela (String $nomeTabela) {
        global $localBanco;
  
        return $localBanco.'/'.$nomeTabela.'.json';
    }
  
    function criaTupla (String $nomeTabela, array $tupla) {
      $lista = pegaTabela($nomeTabela);
      $tupla['id'] = count($lista) + 1;
      array_push($lista, $tupla);
  
      consisteTabela($nomeTabela, $lista);
    }
  
    function consisteTabela (String $nomeTabela, array $lista) {
      file_put_contents(pegaArquivoTabela($nomeTabela), json_encode($lista));
    }
  
    function editaTupla (String $nomeTabela, array $tuplaAlterada) {
      $lista = pegaTabela($nomeTabela);
      foreach($lista as $key=>$value) {
        if ($value['id'] == $tuplaAlterada['id']){
            $lista[$key] = $tuplaAlterada;
            
            break;
        }
      }
  
      consisteTabela($nomeTabela, $lista);
    }
  
    function deletaTupla (String $nomeTabela, int $id) {
      $lista = pegaTabela($nomeTabela);
      foreach($lista as $key=>$value) {
        if ($value['id'] == $id){
            unset($lista[$key]);
            
            break;
        }
      }
  
      consisteTabela($nomeTabela, $lista);
    }
?>
