<?php
//session_start();
class API
{
    private $result;
    private $msgErro;
    
    public function __construct()
    {
    }
    
    public function getResult()
    {
        return $this->result;
    }
    public function getMsgErro()
    {
        return $this->msgErro;
    }
    
    // O método abaixo consome os dados do webservice.
    public function getRequest($url)
    {
        // ###################################################
        // # PROCEDIMENTO QUE CAPTURA OS DADOS DO WEBSERVICE #
        // ###################################################
        
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $result = curl_exec($ch);
        
        // ############### FIM DO PROCEDIMENTO  ##############
        
        // As condições abaixo definem qual página redirecionar.
        $url_atual = $_SERVER['REQUEST_URI'];
        if($url_atual === "/test-dev/"){
            if ($result !== FALSE) {
                $this->result   = json_decode($result);
                $qtdeResultados = count($this->result);
                if ($qtdeResultados > 0) {
                    include_once('list.phtml');
                } else {
                    include_once('vazio.phtml');
                }
            } else {
                $this->msgErro = curl_error($ch);
                require_once('erro.phtml');
            }
        }

    }
    function insert()
    {
        $data = array(
            'marca' => $_POST['marca'],
            'modelo' => $_POST['modelo'],
            'ano' => $_POST['ano']
        );
        
        $data_string = json_encode($data);
        
        $ch = curl_init('http://localhost:3000/carros?action=insert');
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'Content-Type: application/json',
            'Content-Length: ' . strlen($data_string)
        ));
        
        $result = curl_exec($ch);
    }
    
    function delete($id)
    {
        $api_url = "http://localhost:3000/carros/" . $id . "";
        $ch      = curl_init();
        curl_setopt($ch, CURLOPT_URL, $api_url);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'DELETE');
        $result   = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);
        
        return $result;
    }
    
    function fetch_single($id)
    {
        $api_url = "http://localhost:3000/carros/" . $id . "";
        $client  = curl_init($api_url);
        curl_setopt($client, CURLOPT_RETURNTRANSFER, true);
        $response = curl_exec($client);
        echo $response;
    }
    
    function update()
    {
        $id        = $_POST['hidden_id'];
        $form_data = array(
            'marca' => $_POST['marca'],
            'modelo' => $_POST['modelo'],
            'ano' => $_POST['ano'],
            'id' => $_POST['hidden_id']
        );
        $api_url   = "http://localhost:3000/carros/" . $id . "";
        $ch        = curl_init($api_url);
        
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "PUT");
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($form_data));
        
        $response = curl_exec($ch);
    }
}

?>