<?php
namespace app\models;

class Client extends Database
{
    const table_name = 'client';

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
            [['full_name'], 'string', 'min' => 3],
            [['gender'], 'string', 'length' => 1],
            [['phone'], 'string', 'min' => 12],
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