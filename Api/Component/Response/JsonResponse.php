<?php

namespace Api\Component\Response;

class JsonResponse
{
    private $message;
    private $statusCode;

    public function __construct(array $message, int $statusCode)
    {
        $this->message = $message;
        $this->statusCode = $statusCode;
        $this->createResponse();
    }

    private function createResponse()
    {
        http_response_code($this->statusCode);

        echo json_encode($this->message, true);
    }
}