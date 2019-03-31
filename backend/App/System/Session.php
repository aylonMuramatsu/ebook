<?php
namespace App\System;
use App\Model\SessionModel;
use App\Model\UserModel;

class Session {
    private static $instance;    
    private $token;


    public static function getInstance()
    {
        if (self::$instance == null) {
            $className = __CLASS__;
            self::$instance = new $className();
        }

        return self::$instance;
    }


    public static function setToken($token){
        self::getInstance()->token = $token;
    }

    public static function getToken(){
        return self::getInstance()->token;
    }

    public static function get(){
        if(self::getInstance()->token != null){
            $token = self::getInstance()->token;
            $data_token = JWT::decode($token, APP_KEY);
            //Defino os dados que uma sessao possui
            $sessao_model = new SessionModel();
            $sessao_model->SetToken($token);
            $sessao_model->SetUsuario(UserModel::findById($data_token->id));
            return $sessao_model;
        }
        else{
            $validation = new Validation();
            $validation->add("Sessão expirada!");
            throw new BusinessException($validation);
        }
    }
    
}