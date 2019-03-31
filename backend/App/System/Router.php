<?php 
namespace App\System;
class Router extends RouterConfig{
    private static $instance;    

    public static function getInstance()
    {
        if (self::$instance == null) {
            $className = __CLASS__;
            self::$instance = new $className();
        }

        return self::$instance;
    }

    public static function load(){
        //Verifico se foi informado a versao
        if(!isset($_GET["ctrl"])){
            $validation = new Validation();
            $validation->add("Informe a versão da API.");
            throw new BusinessException($validation);
        }
        //Capturo a url solicitada
        $url = $_GET["ctrl"];
        //pego os niveis de acesso
        $nivel = explode('/',$url);
        //Captura a versao da API
        $version =  $nivel[0];
        //Crio uma identidade para as rotas da versao
        $pathRoute = str_replace($version . "/", "", $url);
        
        //Verifico se a versao da API existe.
        if(!self::findByVersion($version)){
            $validation = new Validation();
            $validation->add("Versão da API não existente.");
            throw new BusinessException($validation);
        }
        //Verifico se foi informado algum End-point
        if(count($nivel) == 1 ){
            $validation = new Validation();
            $validation->add("Informe o End-Point.");
            throw new BusinessException($validation);

        }


        //Procuro o modulo para executar
        $procurar = self::findByModule($version, $pathRoute);
        //Executa o modulo
        if(!is_null($procurar)){
            $controller = new $procurar[0]();
            $action = $procurar[1];
            $auth = $procurar[2];

            if($auth == "private"){
                //Se for privado precisa verificar o token de acesso.
                //Verifico se esta informando o X-Auth-Token
                if (function_exists('apache_request_headers')) {
                    $headers = apache_request_headers();
                    if (isset($headers['X-Auth-Token'])) {
                        $token = $headers['X-Auth-Token'];
                        Session::setToken($token);
                    }
                }
                //Ira verificar se esta tudo bem com o token e se esta aprovado para acessar a rota
                Session::get();
                return $controller->$action();
            }
            else {
                //Se for publico executa na hora
                return $controller->$action();
            }

        }
        else { 
            //Avisa que a rota nao foi encontrado
            $validation = new Validation();
            $validation->add("Rota não registrada.");
            throw new BusinessException($validation);
        }
    }

    //Procura por uma versão
    public static function findByVersion($version){
        foreach (self::getInstance()->route as $key => $item) {
            if($key == $version) return true;
        }
        return false;
    }
    //Procura um Modulo
    public static function findByModule( $version, $module){
        foreach (self::getInstance()->route as $key => $route) {
            if($version == $key){
                foreach ($route as $key => $i) {
                    if($key == $module){
                        return $i;
                    }
                }
            }
        }
        return null;
    }

}