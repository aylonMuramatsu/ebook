<?php
namespace App\Controller;

use App\Business\UserBusiness;
use App\System\BusinessException;

class UserController extends \App\System\Controller{
    //Lista todos os usuario
    public function fetch(){
        try{
            $data = new \stdClass();
            $data->nome = $this->Get("nome");
            return UserBusiness::fetch($data);
        }
        catch(BusinessException $e){
            return $e;
        }
    }
    //Procura um usuario pelo ID
    public function findById(){
        try{
            $data = new \stdClass();
            $data->id = $this->Get("id");

            return UserBusiness::findById($data);
        }
        catch(BusinessException $e){
            return $e;
        }
    }

    //Inserir um novo usuario
    public function save(){
        try{
            //Espera-se um JSON
            $data = $this->GetData();
            return @UserBusiness::save($data);
        }
        catch(BusinessException $e){
            return $e;
        }
    }

    //Excluir um usuario
    public function delete(){
        try{
            $data = new \stdClass();
            $data->id = $this->Get("id");

            return UserBusiness::delete($data);
        }
        catch(BusinessException $e){
            return $e;
        }
    }



}