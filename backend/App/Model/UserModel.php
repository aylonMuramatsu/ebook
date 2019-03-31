<?php
namespace App\Model;

use App\Repository\UserRepository;
use App\System\Validation;

class UserModel extends UserRepository{
    private $id;
    private $nome;
    private $email; 
    private $senha;
    private $inserido_por;
    private $inserido_em;
    private $usuario;


    public function SetId($v){ $this->id = $v; }
    public function SetNome($v){ $this->nome = $v; }
    public function SetEmail($v){ $this->email = $v; }
    public function SetSenha($v){ $this->senha = $v; }
    public function SetInseridoPor($v) { $this->inserido_por = $v; }
    public function SetInseridoEm($v){ $this->inserido_em = $v; }
    public function SetUsuario($v){ $this->usuario = $v; }

    public function GetId(){ return $this->id; }
    public function GetNome(){ return $this->nome; }
    public function GetEmail(){ return $this->email; }
    public function GetSenha(){ return $this->senha; }
    public function GetInseridoPor(){ return $this->inserido_por; }
    public function GetInseridoEm(){ return $this->inserido_em; }
    public function GetUsuario(){ return $this->usuario; }

    public function validate(){
        $validation = new Validation();
        if(strlen($this->nome) == 0 ) $validation->add("Informe o nome");
        return $validation;
    }


}