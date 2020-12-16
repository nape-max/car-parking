<?php
namespace app\models;

use yii\base\Model;

class Car extends Model
{
    public $brand;
    public $model;
    public $color;
    public $license_plate_number;
    public $is_on_parking;
    public $client_id;
    
    public function rules() {
        return [
            [['brand', 'model', 'color', 'license_plate_number', 'is_on_parking', 'client_id'], 'required'],
        ];
    }
}