<?php
namespace App\Business;

use App\System\BusinessException;
use App\Model\UserModel;
use App\System\Validation;
use App\System\JWT;
use App\System\Session;


class AuthBusiness {
    /**
     * Regra de Negocio responsavel por realizar o login
     *
     * @param Object $data
     * @return SessionModel
     */
    public static function login($data){
        $validation = new Validation();
        if(!isset($data->usuario)||is_null($data->usuario)){
            $validation->add("Informe o usuario");
        }
        
        if(!isset($data->senha)||is_null($data->senha)){
            $validation->add("Informe a senha");
        }

        if(!$validation->isOkay()){
            throw new BusinessException($validation);
        }

        //Login Sucesso
        $user_model = UserModel::request_login($data);
        if(!is_null($user_model)){
            //Conseguiu validar o login, sendo assim eu crio um token de acesso para esse usuario
            $token = JWT::encode(
                array(
                    'id' => $user_model->GetId(),
                    'exp' => time() + (60*60* 4/*NUMERO DE HORAS*/)
                ), APP_KEY
            );
            //Guardo esse token na sessao
            Session::setToken($token);
            return array(
                'token' => Session::get()->GetToken(),
                'usuario' => array(
                    //Colocar dados publicos aqui, serve para usar dados basicos
                    'id' => Session::get()->GetUsuario()->GetId(),
                    'nome' => Session::get()->GetUsuario()->GetNome(),
                    'email' => Session::get()->GetUsuario()->GetEmail()
                ),
            );
            
        }
        
        $validation->add("Usuário/Senha invalido.");
        throw new BusinessException($validation);

    }
}