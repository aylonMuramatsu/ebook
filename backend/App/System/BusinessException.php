<?php 
namespace App\System;

class BusinessException extends \Exception{
    public $validation; 
    public $trace;

    public function __construct($validation){
        $this->validation = $validation;
        if(defined("DEBUG") && DEBUG) $this->trace = $this->getTrace();

        if(!is_null($validation)){
            parent::__construct("Business Exception");
        }
    }
}
