<?php
namespace app\models;

use yii\base\Model;

class Car extends Database
{
    const SCENARIO_DEFAULT = 'default';
    const SCENARIO_INSERT = 'insert';

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
            [['is_on_parking'], 'boolean'],
            ['is_on_parking', 'default', 'value' => true],
            [['brand', 'model', 'color', 'license_plate_number', 'is_on_parking', 'client_id'], 'required'],
        ];
    }

    public function scenarios()
    {
        return [
            self::SCENARIO_DEFAULT => [
                'id',
                'brand',
                'model',
                'color',
                'license_plate_number',
                'is_on_parking',
                'client_id',
                'client'
            ],
            self::SCENARIO_INSERT => [
                'id',
                'brand',
                'model',
                'color',
                'license_plate_number',
                'is_on_parking',
                'client_id',
            ],
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

        if (empty($this->client)) {
            $this->addError('client_id', 'Client must be exist.');
        }

        if (empty($this->errors)) {
            return true;
        } else {
            return false;
        }
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