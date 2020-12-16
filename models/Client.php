<?php
namespace app\models;

use yii\base\Model;

class Client extends Model
{
    public $full_name;
    public $gender;
    public $phone;
    public $address;

    public function rules()
    {
        return [
            [['full_name', 'gender', 'phone'], 'required'],
            [['full_name'], 'string', 'min' => 3],
            [['gender'], 'string', 'length' => 1],
            [['phone'], 'string', 'min' => 12],
        ];
    }
}