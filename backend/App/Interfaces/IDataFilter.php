<?php
namespace App\Interfaces;

interface IDataFilter {
    public function Add($name, $operator, $value, $connector);
    public function Get();
}