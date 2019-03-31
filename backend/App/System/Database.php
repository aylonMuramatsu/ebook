<?php 
namespace App\System;
class Database{
    private static $instance;    
    private $engine;
    private $host; 
    private $database;
    private $user;
    private $pass;
    private $conn; 

    function __construct(){
        $this->engine = "mysql";
        $this->host = DB_HOST;
        $this->database = DB_NAME;
        $this->user = DB_USER;
        $this->pass = DB_PASSWORD;
        $this->port = DB_PORT;

        $this->dns = 'mysql:host='.DB_HOST.';port='.$this->port.';dbname='.DB_NAME.';charset=utf8';
    }

    static function getInstance()
    {
        if (self::$instance == null) {
            $className = __CLASS__;
            self::$instance = new $className();
        }

        return self::$instance;
    }

    function connect(){
        try{
            $this->conn = @new \PDO($this->dns,$this->user,($this->pass ?: NULL) );
            $this->conn->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
            $this->conn->exec("set names utf8");
            $this->conn->exec(" SET SESSION sql_mode='' ");
                        
        }
        catch(\PDOException $e){
            $validation = new Validation();
            $validation->add("Falha ao se conectar com o banco de dados");
            throw new BusinessException($validation);
        }

        return true;
    }

    static function query($sql, $params = null, $row_object=false){
        if(self::getInstance()->connect()){
            try
            {
                $stmt = self::getInstance()->conn->prepare($sql);
                $stmt->execute($params);

                if (!$row_object) {
                    return $stmt->fetchAll(\PDO::FETCH_ASSOC);
                }
                else {
                    return $stmt->fetchAll(\PDO::FETCH_OBJ);
                }
                
            }
            catch (\PDOException $e)
            {
                if ($e->getCode() == '42S02') {
                    $validation = new Validation();
                    $validation->add('Tabela não encontrada. ' . $e->getMessage());
                    throw new BusinessException($validation);
                }
                else {
                    $validation = new Validation();
                    $validation->add('Erro na consulta SQL: ' . $e->getMessage() . ' Arquivo: ' . $e->getFile() . ' Linha: ' . $e->getLine());
                    throw new BusinessException($validation);
                }
                    
                return false;
            }
        }
    }
    
    static function exec($sql, $params=null){
        if (self::getInstance()->connect()) {
            try {
                $stmt = self::getInstance()->conn->prepare($sql);
                $result = $stmt->execute($params);
                return $result;
            }
            catch (\PDOException $e) {
               $validation = new Validation();
               $validation->add('Falha na query, OBS:' . $e->getMessage());
               $validation->add($sql);
               throw new BusinessException($validation);
            }
        }
    }

    static function last_insert_id()
    {
        return (int)self::getInstance()->conn->lastInsertId();
    }

    static function has_rows(&$array)
    {
        return count($array) > 0;
    }

    static function check_to_sql($val)
    {
        return ($val == true || $val === "true" ? 'S' : 'N');
    }

    static function sql_to_check($val)
    {
        return ((string)$val === 'S' ? true : false);
    }

    static function key_to_sql($val)
    {
        return ((int)$val > 0 ? (int)$val : null);
    }

}