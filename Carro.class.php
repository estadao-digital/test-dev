<?php
class Carro
{
    public function obterDados($id)
    {  
        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_PORT => "3000",
            CURLOPT_URL => "http://localhost:3000/carros/$id",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "GET",
            CURLOPT_POSTFIELDS => "undefined=",
            CURLOPT_HTTPHEADER => array(
            "Content-Type: application/x-www-form-urlencoded",
            "Postman-Token: bde49c07-3e32-413e-951b-e0daec939962",
            "cache-control: no-cache"
            ),
        ));
        
        $response = curl_exec($curl);
        $err = curl_error($curl);
        
        curl_close($curl);
        
        if ($err) {
            echo "cURL Error #:" . $err;
        } else {
            echo $response;
        }


    }

    public function editarDados($dados)
    {

        $curl = curl_init();
        curl_setopt_array($curl, array(
        CURLOPT_PORT => "3000",
        CURLOPT_URL => "http://localhost:3000/carros/$dados[0]",
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => "",
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 30,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => "PATCH",
        CURLOPT_POSTFIELDS => "id=$dados[0]&Marca=$dados[2]&Modelo=$dados[1]&Ano=$dados[3]&undefined=",
        CURLOPT_HTTPHEADER => array(
            "Content-Type: application/x-www-form-urlencoded",
            "Postman-Token: 5cb1b66e-998a-46ae-b883-e3acbfc2a175",
            "cache-control: no-cache"
        ),
        ));

        $response = curl_exec($curl);
        $err = curl_error($curl);

        curl_close($curl);

        if ($err) {
        echo "cURL Error #:" . $err;
        } else {
        echo 1;
        }
    }

    public function criarCarro($dados)
    {
        $curl = curl_init();

        curl_setopt_array($curl, array(
        CURLOPT_PORT => "3000",
        CURLOPT_URL => "http://localhost:3000/carros",
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => "",
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 30,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => "POST",
        CURLOPT_POSTFIELDS => "id=&Marca=$dados[0]&Modelo=$dados[1]&Ano=$dados[2]&undefined=",
        CURLOPT_HTTPHEADER => array(
            "Content-Type: application/x-www-form-urlencoded",
            "Postman-Token: c10cec83-b86b-4fe0-9dcc-cbb7eb05f5e6",
            "cache-control: no-cache"
        ),
        ));

        $response = curl_exec($curl);
        $err = curl_error($curl);

        curl_close($curl);

        if ($err) {
        echo 0;
        } else {
        echo 1;
        }
    }

    public function apagar($id)
    {
        $curl = curl_init();

        curl_setopt_array($curl, array(
        CURLOPT_PORT => "3000",
        CURLOPT_URL => "http://localhost:3000/carros/$id",
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => "",
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 30,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => "DELETE",
        CURLOPT_POSTFIELDS => "",
        ));

        $response = curl_exec($curl);
        $err = curl_error($curl);

        curl_close($curl);

        if ($err) {
        echo "cURL Error #:" . $err;
        } else {
        echo 1;
        }
    }
}
?>