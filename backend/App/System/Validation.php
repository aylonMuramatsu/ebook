<?php
namespace App\System;

class Validation { 
    public $messages = [];

    //Adiciona uma nova mensagem
    public function add($message){
        $this->messages[] = $message;
    }

    //Retorna true se estive tudo okay com os dados
    public function isOkay(){
        return count($this->messages) == 0;
    }
}