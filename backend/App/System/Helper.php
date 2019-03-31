<?php
namespace App\System;

class Helper {
    public static function Now(){
        $dt_now = new \DateTime('now');
        return $dt_now->format('Y-m-d H:i:s');
    }

    public static function GetUpdated($old, $actually){
        if(is_null($old) && !is_null($actually)) return $actually;
        else if(!is_null($old) && is_null($actually)) return $old;
        else if($actually == "") return NULL;
        else if(!is_null($actually) && !is_null($old) && $actually != $old) return $actually;
        else return $old;
    }
}