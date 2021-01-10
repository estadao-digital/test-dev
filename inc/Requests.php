<?php
namespace Core;


class Requests{
    private $url;
    private $apiKey;
    public function __construct($url,$apiKey){
        $this->url=$url;
        $this->apiKey=$apiKey;
    }

    public function get(){
        $curl = curl_init();

            curl_setopt_array($curl, array(
            CURLOPT_URL => $this->url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'GET',
            CURLOPT_HTTPHEADER => array(
                'apikey: '. $this->apiKey
            ),
            ));

            $response = curl_exec($curl);

            curl_close($curl);
            return $response;
    }
}