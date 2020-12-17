<?php
namespace app\models;

use yii\base\Model;

class Car extends Database
{
    public $brand;
    public $model;
    public $color;
    public $license_plate_number;
    public $is_on_parking;
    public $client_id;

    public $old_attributes;
    
    public function rules() {
        return [
            [['brand', 'model', 'color', 'license_plate_number', 'is_on_parking', 'client_id'], 'required'],
        ];
    }

    public static function getTableName()
    {
        return 'car';
    }

    public static function getClassName()
    {
        return __CLASS__;
    }
}