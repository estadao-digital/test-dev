<?php
require_once __DIR__ . '/api-handler.php';

try {
  $uri   = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
  $uri   = explode( '/', $uri );
  $input = (array) json_decode(file_get_contents('php://input'), TRUE);

  $api_handler = new API_Handler_Class($uri, $input);
  $api_handler->validate();

  $response = $api_handler->handle_model($_SERVER["REQUEST_METHOD"]);

  echo $api_handler->response_handler($input, $response);
  die;
} catch (Exception $e) {
  echo $api_handler->response_handler($input, [], $e->getMessage(), 500);
  die;
}
