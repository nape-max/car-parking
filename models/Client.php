<?php
namespace app\models;

class Client extends Database
{
    public $id;
    public $full_name;
    public $gender;
    public $phone;
    public $address;

    private $old_attributes;

    public function rules()
    {
        return [
            [['full_name', 'gender', 'phone'], 'required'],
            [['address'], 'safe'],
            [['full_name'], 'string', 'min' => 3],
            [['gender'], 'string', 'length' => 1],
            [['phone'], 'string', 'min' => 12, 'max' => 20],
        ];
    }

    public static function getFieldsList() {
        return [
            'id',
            'full_name',
            'gender',
            'phone',
            'address',
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
        return 'client';
    }

    public static function getClassName()
    {
        return __CLASS__;
    }
}