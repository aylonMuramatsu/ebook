<?php
namespace App\System;

class RouterConfig {
    public $route = array(
        'v1' => array(
            'user' => array("App\Controller\UserController", "fetch","public"),
            'user/findById' => array("App\Controller\UserController", "findById", "public"),
            'user/save' => array("App\Controller\UserController", "save", "public"),
            'user/delete' => array("App\Controller\UserController", "delete", "public"),
            'login' => array("App\Controller\AuthController", "login", "public"),
            'teste' => array("App\Controller\AuthController","auth", "private")

            
        )
    );
}