<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\db\Query;

class Database extends Model
{
    public static function getTableName()
    {
        return null;
    }

    public function isChanged()
    {
        $isChanged = false;
        $oldAttributes = $this->getOldAttributes();
        
        if (!empty($oldAttributes)) {
            foreach ($this as $key=>$value) {
                if ($value != $oldAttributes[$key]) {
                    $isChanged = true;
                }
            }
            
            if ($isChanged) {
                return true;
            }
        }

        return false;
    }

    public static function databaseGetAll()
    {
        if (!is_null(static::getTableName())) {
            $allEntriesDatabase = (new Query())
                ->select("*")
                ->from(static::getTableName())
                ->all();

            $objects = [];

            foreach($allEntriesDatabase as $entry) {
                $newObject = new static();  
                
                foreach ($newObject->attributes as $key=>$value) {
                    $newObject[$key] = $entry[$key];
                }

                $newObject->setOldAttributes($newObject->attributes);

                $objects[] = $newObject;
            }
        } else {
            return false;
        }
    }

    public function databaseInsert()
    {
        $attributes = $this->attributes;

        if ($this->validate()) {
            $query = Yii::$app->db
                ->createCommand()
                ->insert(static::getTableName(), $attributes)
                ->execute();

            return $query;
        } else {
            return false;
        }
    }

    public function databaseUpdate()
    {
        $attributes = $this->attributes;

        if ($this->validate() && $this->isChanged()) {
            $query = Yii::$app->db
                ->createCommand()
                ->update(static::getTableName(), $attributes, 'id=' . $this->id)
                ->execute();

            return $query;
        } else {
            return false;
        }
    }

    public static function databaseFind($field, $sign, $value)
    {
        $classFields = static::getFieldsList();

        if (
            is_string($field) && in_array($field, $classFields, true) &&
            is_string($sign) && (strlen($sign) == 1)
            ) {
            $query = (new Query())
                ->select("*")
                ->from(static::getTableName())
                ->where($field . $sign . ":value", [
                    ':value' => $value,
                ])
                ->all();

            return $query;
        }

        return false;
    }

    public static function databaseFindOne($field, $sign, $value)
    {
        $classFields = static::getFieldsList();

        if (
            is_string($field) && in_array($field, $classFields, true) &&
            is_string($sign) && (strlen($sign) == 1)
            ) {
            $query = (new Query())
                ->select("*")
                ->from(static::getTableName())
                ->where($field . $sign . ":value", [
                    ':value' => $value,
                ])
                ->one();

            return $query;
        }

        return false;
    }
}