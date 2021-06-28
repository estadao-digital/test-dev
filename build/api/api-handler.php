<?php
require_once __DIR__ . '/car-class.php';
require_once __DIR__ . '/brands-class.php';

class API_Handler_Class {
  private $uri;
  private $input;
  private $versions;
  private $models;

  public function __construct($uri, $input) {
    $this->uri      = $uri;
    $this->input    = $input;
    $this->versions = [ 'v1' ];
    $this->models   = [ 'carros', 'marcas' ];
  }

  /**
   * Handle response
   *
   * @param array $requested Requested data
   * @param array $data Response data
   * @param string $message Response message
   * @return string JSON
   *
   */
  public function response_handler($requested = [], $data = [], $message = 'Success!', $response_code = 200) {
    $response = [
      'success'      => $response_code === 200,
      'message'      => $message,
      'data'         => $data,
      'current_time' => date('Y-m-d H:i:sP'),
      'requested'    => $requested
    ];

    http_response_code($response_code);
    header('Access-Control-Allow-Origin: *');
    header("Content-Type: application/json; charset=UTF-8");
    header("Access-Control-Allow-Methods: GET,POST,PUT,DELETE");
    header("Access-Control-Max-Age: 3600");
    header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

    return json_encode($response);
  }

  /**
   * Request validation
   *
   * @return string JSON
   */
  public function validate() {
    // * * * * * Validate api version * * * * *
    $api_version = $this->uri[2];
    if (empty($api_version) || !in_array($api_version, $this->versions)) {
      echo $this->response_handler($this->input, [], 'Invalid api version!', 400);
      exit;
    }

    // * * * * * Validate model * * * * *
    $model = $this->uri[3];
    if (empty($model) || !in_array($model, $this->models)) {
      echo $this->response_handler($this->input, [], 'Model does not exist!', 400);
      exit;
    }
  }

  /**
   * Get model from request
   */
  private function get_model_data() {
    $model = [
      'name' => $this->uri[3],
      'id'   => (int) $this->uri[4]
    ];

    return $model;
  }

  /**
   * Call model
   */
  public function handle_model($request_method) {
    $model_data = $this->get_model_data();

    switch ($model_data['name']) {
      case 'carros':
        $car_class = new Car_Class($this->input, $request_method, $model_data['id']);
        return $car_class->process_request();
        break;

      case 'marcas':
        $brands_class = new Brands_Class($this->input, $request_method, $model_data['id']);
        return $brands_class->process_request();
        break;

      default:
        echo $this->response_handler($this->input, [], 'Model does not exist!', 400);
        break;
    }
    exit;
  }
} // API_Handler_Class
