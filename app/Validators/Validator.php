<?php
namespace App\Validators;
use Core\Output;
class Validator{

private $_errors = [];

public function validate($src, $rules = [] ){    
    if($this->checkRules($src, $rules)){
        exit;
    } 
    foreach($src as $item => $item_value){
        if(key_exists($item, $rules)){
            foreach($rules[$item] as $rule => $rule_value){
                if(is_int($rule))
                     $rule = $rule_value;

                switch ($rule){
                    case 'required':
                    if(empty($item_value) && $rule_value){
                        $this->setError($item,ucwords($item). ' required');
                    }
                    break;

                    case 'minLen':
                    if(strlen($item_value) < $rule_value){
                        $this->setError($item, ucwords($item). ' should be minimum '.$rule_value. ' characters');
                    }       
                    break;

                    case 'maxLen':
                    if(strlen($item_value) > $rule_value){
                        $this->setError($item, ucwords($item). ' should be maximum '.$rule_value. ' characters');
                    }
                    break;

                    case 'numeric':
                    if(!ctype_digit($item_value) && $rule_value){
                        $this->setError($item, ucwords($item). ' should be numeric');
                    }
                    break;
                    case 'alpha':
                    if(!ctype_alpha(str_replace(' ', '', $item_value)) && $rule_value){
                        $this->setError($item, ucwords($item). ' should be alphabetic characters');
                    }
                }
            }
        }
    }    
    if($this->getError()){
        Output::JSON($this->getError());
        exit;
    }
  
}

public function checkRules($src, $rules = [] ){
    if(!is_array($src)){
        $this->setError('bad request', 'fields are expected');
        Output::JSON($this->getError());
        return true;
      }; 

      $error=0;
      foreach($rules as $key => $rl){
         if(!array_key_exists($key ,$src)){
            $this->setError($key, 'the '.$key.' field are expected') ;
            $error++;
         } 
      }

      if($error>0){
        Output::JSON($this->getError());
        return true;
      }

}

private function setError($item, $error){
    $this->_errors[$item][] = $error;
}


public function getError(){
    if(empty($this->_errors)){ return false;}
    return $this->_errors;
}



}