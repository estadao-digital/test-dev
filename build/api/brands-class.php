<?php

require_once __DIR__ . '/api-handler.php';

class Brands_Class extends API_Handler_Class {
  private $input;
  private $request_method;
  private $ID;
  private $data;

  const DB_FILE = 'db.json';

  public static $fields = [ 'name' ];

  public function __construct($input, $request_method, $ID) {
    $this->input          = $input;
    $this->request_method = $request_method;
    $this->ID             = $ID;
    $this->data           = json_decode(file_get_contents(self::DB_FILE));
  }

  /**
   * Process Request
   */
  public function process_request() {
    switch ($this->request_method) {
      case 'POST':
        return $this->post_handler();
        break;
      case 'PUT':
        return $this->put_handler();
        break;
      case 'DELETE':
        return $this->delete_handler();
        break;
      default:
        return $this->get_handler();
    }
  }

  /**
   * Get Handler
   */
  private function get_handler() {
    $data = $this->data->brands;

    // * * * * * Check if has ID * * * * *
    if ($this->ID) {
      $key = $this->get_by_id($this->ID);
      return $data[$key];
    }

    // * * * * * Get all * * * * *
    return $data;
  }

  /**
   * Get by ID
   */
  private function get_by_id($ID) {
    $data = $this->data;
    $key = array_search($ID, array_column($data->brands, 'id'));

    if (!$key && $key !== 0) {
      echo $this->response_handler($this->input, [], 'ID não encontrado!', 404);
      die;
    }

    return $key;
  }

  /**
   * Post Handler
   */
  private function post_handler() {
    $data = $this->data;

    // * * * * * New ID * * * * *
    $ids = array_column($data->brands, 'id');
    $next_id = max($ids) + 1;

    // * * * * * New append data * * * * *
    $append_data = $this->valid_input();
    $append_data['id'] = $next_id;

    // * * * * * Append new data * * * * *
    $data->brands[] = $append_data;

    // * * * * * Save data * * * * *
    $this->save_data($data);

    return $append_data;
  }

  /**
   * Put Handler
   */
  private function put_handler() {
    $data = $this->data;

    // * * * * * Check if has ID * * * * *
    if (!$this->ID) {
      echo $this->response_handler($this->input, [], 'ID não encontrado!', 404);
      die;
    }

    // * * * * * Update data * * * * *
    $key              = $this->get_by_id($this->ID);
    $new_data         = $this->valid_input();
    $new_data['id']   = $this->ID;
    $data->brands[$key] = $new_data;

    // * * * * * Save data * * * * *
    $this->save_data($data);

    return $new_data;
  }

  /**
   * Delete Handler
   */
  private function delete_handler() {
    $data = $this->data;

    // * * * * * Check if has ID * * * * *
    if (!$this->ID) {
      echo $this->response_handler($this->input, [], 'ID não encontrado!', 404);
      die;
    }

    // * * * * * Delete data * * * * *
    $key = $this->get_by_id($this->ID);
    unset($data->brands[$key]);

    // * * * * * Save data * * * * *
    $this->save_data($data);

    return $data;
  }

  /**
   * Save data
   */
  private function save_data($new_data) {
    $save_db = file_put_contents(self::DB_FILE, json_encode($new_data));

    if (!$save_db) {
      echo $this->response_handler($this->input, [], 'Erro ao salvar.', 500);
      die;
    }
  }

  /**
   * Validate data
   */
  private function valid_input() {
    $data = [];

    // * * * * * Check keys * * * * *
    foreach (self::$fields as $key) {
      if (!array_key_exists($key, $this->input)) {
        echo $this->response_handler($this->input, [], "Campo \"$key\" em branco", 400);
        die;
      }
    }

    $new_title = htmlspecialchars(stripslashes(trim($this->input['name'])));
    if (empty($new_title)) {
      echo $this->response_handler($this->input, [], "Nome inválido", 400);
      die;
    }

    // * * * * * Filtered data * * * * *
    $data['title']   = $new_title;

    return $data;
  }
}
