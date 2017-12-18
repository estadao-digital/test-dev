<?php

namespace Cars\Car\Validators;
use Validator;

class CarValidator{
    
    private $redirect = false;
    private $messages = false;
    
    public function __construct( $redirect = false )
    {
        $this->redirect = $redirect;
        $this->setMessages();
    }

    public function validateCreate( $fields )
    {
      return $this->make( $fields , [
             'name' => 'required',
             'model' => 'required',
             'image_location' => 'required',
             'year' => 'required|numeric',
             'excluded' => 'numeric',
             'manufacturer_id' => 'required|numeric',
            ]);

    }

    public function validateUpdate( $fields )
    {
       return $this->make( $fields , [
                'name' => 'required',
                'model' => 'required',
                'image_location' => 'required',
                'year' => 'required|numeric',
                'excluded' => 'numeric',
                'manufacturer_id' => 'required|numeric',
            ]);

    }

    public function make( $fields , $rules ){
         
        $validate =  Validator::make( $fields , $rules , $this->messages );
        if($this->redirect === true)
            return $validate->validate();
        return $validate;

    }

    private function setMessages(){
        $this->messages = [
                            'name.required'=>'Preencha o campo Nome',
                            'model.required'=>'Preencha o campo Modelo',
                            'year.required'=>'Preencha o campo Ano',
                            'manufacturer_id.required'=>'Selecione um Fabricante',
                            'year.numeric'=>'O Campo Ano deve ser numérico',
                            'manufacturer_id.numeric'=>'O Campo Fabricante deve ser numérico',
                            'image_location.required'=>'Preencha o campo Imagem',
                            ];
    }


}