<?php
namespace models{
	/*
	Class Car
	*/
	class Car extends AppModel{

        // it's important to define every field and type to bind it whenever it's necessary
        protected $fields = array(
            'id' => 'int',
            'model' => 'string',
            'brand_name' => 'string',
            'year' => 'int'
        );
        protected $validations = array(
            'model' => array('required','notEmpty'),
            'brand_name' => array('required','notEmpty'),
            'year' => array('required','notEmpty','isInt')
        );

		function __construct(){
            parent::__construct();
            $this->table = 'cars';  // initiate table to use on queries
        }
        
        
    }
}
