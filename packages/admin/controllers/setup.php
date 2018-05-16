<?php
error_reporting(E_ERROR | E_PARSE);

class setup extends controller
{

    function __construct()
    {
        parent::__construct();
    }

    function index()
    {
        if (! is_writable(getcwd() . '/config')) {
            $msg = getcwd() . '/config is not writable !';
        }
        
        $v = new setupView();
        $v->index($msg);
    }

    function save()
    {
        if (! is_writable(getcwd() . '/config')) {
            $msg = getcwd() . '/config is not writable !';
            $v = new setupView();
            $v->index($msg);
        } else {
           $m = new setupModel();
           $m->save($this->request);
           page::addBody("feito");
           page::render();
        }
    }

    function fail()
    {
        page::addBody("Database access error");
        page::render();
    }
}