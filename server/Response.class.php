<?php

// Classe que representa um objeto resposta, que será respondido nas requisições.
class Response
{
    // Código de status HTTP
    var $statusCode;

    // Mensagem caso exista a necessidade
    var $message;

    // Variável que conterá os dados que serão respondidos
    var $data;

    function __construct($statusCode, $message, $data)
    {
        $this->statusCode = $statusCode;
        $this->message = $message;
        $this->data = $data;
    }

    function getStatusCode()
    {
        return $this->statusCode;
    }
    function setStatusCode($statusCode)
    {
        $this->statusCode = $statusCode;
    }
    function getMessage()
    {
        return $this->message;
    }
    function setMessage($message)
    {
        $this->message = $message;
    }
    function getData()
    {
        return $this->data;
    }
    function setData($data)
    {
        $this->data = $data;
    }

    // Função que retorna o objeto responde completo no formato json
    function getJsonAll()
    {
        return json_encode($this);
    }
}
