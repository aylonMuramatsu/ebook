<?php
define("APP_NAME", "Primeira API");
define("DB_HOST", "127.0.0.1");
define("DB_USER", "root");
define("DB_PASSWORD", "123mudar");
define("DB_NAME", "ebook");
define("DB_PORT", "3306");
//JWT
define("APP_KEY", "146a0a05-1443-4539-9d1e-97656b94e2c1");
define("DEBUG" , false);

date_default_timezone_set('America/Sao_Paulo');
header("Cache-Control: no-cache");
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: *");
header("Access-Control-Allow-Headers: Origin, X-Auth-Token, Authorization, Content-Type, Accept");
header("Access-Control-Max-Age: 1728000");