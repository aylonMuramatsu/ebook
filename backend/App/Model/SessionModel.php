<?php
namespace App\Model;

class SessionModel {
    private $usuario;
    private $token;

    public function SetUsuario($v) { $this->usuario = $v; }
    public function SetToken($v){ $this->token = $v; }
    public function GetUsuario(){ return $this->usuario; }
    public function GetToken(){ return $this->token; }
}