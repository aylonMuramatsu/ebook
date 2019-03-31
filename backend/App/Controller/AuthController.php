<?php
namespace App\Controller;
use App\System\Controller;
use App\Business\AuthBusiness;
class AuthController extends Controller{
    public function login(){
        $data = $this->GetData();
        return AuthBusiness::login($data);
    }

    public function auth(){
        return array("status" => true);

    }
}