<?php

namespace Core;

class Json
{
  public function getJsonFile($path)
  {
    return file_get_contents($path);
  }

  public function jsonResponse($code, $data)
  {
    // $this->cors();
    http_response_code($code);
    return $data;
  }

  public function jsonToPhp($file)
  {
    $parse = json_decode($file, true);
    return $parse;
  }

  public function phpToJson($file)
  {
    $parse = json_encode($file);
    return $parse;
  }

  public function saveJasonFile($path, $data)
  {
    file_put_contents($path, $data);
  }

  public function jsonMessage($message)
  {
    header('Content-Type: text/html; charset=utf-8');
    return json_encode($message, \JSON_UNESCAPED_UNICODE);
  }

  private function cors() {

    if (isset($_SERVER['HTTP_ORIGIN'])) {

        header("Access-Control-Allow-Origin: http://localhost:3000");
        header('Access-Control-Allow-Credentials: true');
    }

    if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS') {

        if (isset($_SERVER['HTTP_ACCESS_CONTROL_REQUEST_METHOD']))
            header("Access-Control-Allow-Methods: OPTIONS, PUT, POST, GET, DELETE");

        if (isset($_SERVER['HTTP_ACCESS_CONTROL_REQUEST_HEADERS']))
            header("Access-Control-Allow-Headers: {$_SERVER['HTTP_ACCESS_CONTROL_REQUEST_HEADERS']}");

        exit(0);
    }

      header('Content-type: application/json');
    }

}
