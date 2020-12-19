<?php
namespace app\models;

use yii\base\Model;

class Car extends Database
{
    public $id;
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
            [['license_plate_number'], 'unique'],
        ];
    }

    public function attributes()
    {
        return [
            'id',
            'brand',
            'model',
            'color',
            'license_plate_number',
            'is_on_parking',
            'client_id',
            'client'
        ];
    }

    public function validaTe($attributeNames = NULL, $clearErrors = true)
    {
        $isParentValidate = parent::validate();

        if (!empty($this->client) && $isParentValidate) {
            return true;
        } else {
            if (!empty($this->client_id)) {
                $this->addError('client_id', 'Client must be exist.');
            }
        }

        return false;
    }

    public static function getFieldsList()
    {
        return [
            'id',
            'brand',
            'model',
            'color',
            'license_plate_number',
            'is_on_parking',
            'client_id',
        ];
    }

    public function getOldAttributes()
    {
        return $this->old_attributes;
    }

    public function setOldAttributes($attributes)
    {
        $this->old_attributes = $attributes;
    }

    public static function getTableName()
    {
        return 'car';
    }

    public static function getClassName()
    {
        return __CLASS__;
    }

    public function getClient()
    {
        return Client::databaseFindOne('id', '=', $this->client_id);
    }
}