<?php

class Template
{
    public $file, $view, $template, $render;

    public function __construct($temp = "default", $file_name = "default"){
        $this->template = $temp;
        $this->file = BASE . "templates/$temp/$file_name.phtml";
        
        if(!is_dir(BASE . "templates/$this->template"))
            mkdir(BASE . "templates/$this->template", 0755, true);
        
        if(!file_exists($this->file)){
            $fp = fopen($this->file, "w");
            $fw = fwrite($fp, "Esse é o arquivo <b>\"$file_name.phtml\"</b> do Template <b>\"$temp\"</b>!");
        }
    }
        
    public function display($view = ""){
        if(!empty($view))
            $this->view = BASE . "templates/$this->template/views/$view";
        
        if(!is_dir(BASE."templates/$this->template"))
            die("O Template '$this->template' não existe!");

        if(!file_exists($this->file))
            die("O arquivo '$this->file' não existe!");
        
        include_once($this->file);
    }

    public function loadView($view = ""){
        if(!empty($view))
            $this->view = BASE . "templates/$this->template/views/$view";

        if(file_exists($this->view))
            include_once($this->view);
    }

}