<?php
namespace App\Interfaces;
interface IDataAdapter {
    public static function insert($model);
    public static function update($model);
    public static function delete($model);
    public static function findById($id);
    public static function list($filters);
}