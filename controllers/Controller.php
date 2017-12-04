<?php

namespace controllers;

class Controller {

    protected $db;

    public function __construct() {
        global $config;        
    }

    public function loadView($viewName, $viewData = array()) {
        extract($viewData);
        include 'views/' . $viewName . '.php';
    }

    public function loadTemplate() {
        include 'views/template.php';
    }

    public function loadViewInTemplate($viewName, $viewData) {
        extract($viewData);
        include 'views/' . $viewName . '.php';
    }

}
