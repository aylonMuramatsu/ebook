<?php
namespace App\System;

class Core{
    private static $instance;    
    private $contentType = "";

    public static function init(){
        //inicia como padrao um JSON
        self::setContentType("application/json");

        //Carrega a rota
       
        try{
            if(self::getInstance()->contentType == "application/json") echo json_encode(Router::load());
            else echo json_encode(Router::load());
        }
        catch(BusinessException $error){
            
            echo json_encode($error);
        }
    }

    public static function getInstance()
    {
        if (self::$instance == null) {
            $className = __CLASS__;
            self::$instance = new $className();
        }

        return self::$instance;
    }

    public static function setContentType($value){ 
        header("Content-Type:$value"); 
        self::getInstance()->contentType = $value;
    }

    public static function getContentType(){
        return self::getInstance()->contentType;
    }

}