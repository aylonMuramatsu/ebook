<?php
namespace App\System;
class Controller {
    public function Get($name){ 
        return isset($_GET[$name]) ? $_GET[$name] : null;
    }
    public function Post($name){ 
        return isset($_GET[$name]) ? $_POST[$name] : null;
    }
    public function GetData(){ 
        return (object)json_decode(file_get_contents('php://input'),true);
    }
    public function File($name){
        if(isset($_FILES[$name])){
            return $_FILES[$name];
        }
        return null;
    }
}