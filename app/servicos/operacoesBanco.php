<?php
    $localBanco = 'banco';
    $camposInteiros = Array('marca_id', 'ano');

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
      array_push($lista, trataInteiros($tupla));
  
      consisteTabela($nomeTabela, $lista);
    }

    function trataInteiros ($tupla) {
      global $camposInteiros;

      foreach ($camposInteiros as $campo) {
        if (isset($tupla[$campo])) {
          $tupla[$campo] = (int) $tupla[$campo];
        }
      }

      return $tupla;
    }
  
    function consisteTabela (String $nomeTabela, array $lista) {
      file_put_contents(pegaArquivoTabela($nomeTabela), json_encode($lista));
    }
  
    function editaTupla (String $nomeTabela, array $tuplaAlterada) {
      $lista = pegaTabela($nomeTabela);
      foreach($lista as $key=>$value) {
        if ($value['id'] == (int) $tuplaAlterada['id']){
            $lista[$key] = trataInteiros($tuplaAlterada);
            
            break;
        }
      }
  
      consisteTabela($nomeTabela, $lista);
    }
  
    function deletaTupla (String $nomeTabela, int $id) {
      $lista = pegaTabela($nomeTabela);
      foreach($lista as $key=>$value) {
        if ($value['id'] == (int) $id){
            unset($lista[$key]);
            
            break;
        }
      }
  
      consisteTabela($nomeTabela, $lista);
    }
?>
