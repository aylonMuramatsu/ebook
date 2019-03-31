<?php
namespace App\System;
use App\Interfaces\IDataFilter;

class DataFilter implements IDataFilter{
    private $filters = [];
    private $params = [];
    private $groups = [];
    public function Add($name, $operator, $value, $conector="AND"){
        $sql = "";
        if(count($this->filters) < 1 ){
            $sql = " WHERE $name $operator :$name ";
        }
        else $sql .= "$conector $name $operator :$name ";
        $this->filters[] = $sql;
        $this->params[":$name"] = $value;
    }

    public function AddGroup($name, $operator, $param, $value, $conector = "AND"){
        
        if(count($this->groups) < 1 ){
            $sql = " $name $operator :$param ";
        }
        else $sql = "$conector $name $operator :$param ";

        $this->groups[] = $sql;
        $this->params[":$param"] = $value;
        
    }


    public function Get($groupType=null){
        $sql = implode(" ",$this->filters);
        if(count($this->groups) > 0){
            if(!is_null($groupType)) $sql .= " $groupType ";
            else $sql .= " AND ";
            $sql .= "(";
            foreach ($this->groups as $key => $group) {
                $sql .= $group;
            }

            $sql .= ")";
        }

        return (object)array(
            'sql' => $sql,
            'params' => $this->params
        );
    }

}