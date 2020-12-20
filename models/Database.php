<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\db\Query;

/**
 * Database_Class это класс для работы с базой данных.
 * 
 * Database_Class был создан с целью объединения логики работы
 * с базой данных для всех классов в одном классе.
 */
class Database extends Model
{
    const SCENARIO_DEFAULT = 'default';
    const SCENARIO_BASIC_FIELDS = 'basic_fields';

    public function getCustomScenarios()
    {
        return [
            self::SCENARIO_DEFAULT => $this->attributes(),
            self::SCENARIO_BASIC_FIELDS => $this->attributes(),
        ];
    }

    public function scenarios()
    {
        $scenarios = $this->getCustomScenarios();
        return $scenarios;
    }

    /**
     * Получение имени таблицы (переопределяется в наследниках),
     * используется во всех методах класса Database с помощью
     * позднего связывания static()::
     * 
     * @return null | string
     */
    public static function getTableName()
    {
        return null;
    }
    
    /**
     * Проверяет была ли изменена модель на основе поля oldAttributes
     * 
     * @return bool
     */
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

    /**
     * Находит по ID и возвращает одну запись из базы данных,
     * использует static::getTableName()
     * 
     * @param int $id
     * 
     * @return static::Object
     */
    public static function databaseGetOne($id)
    {
        if (!is_null(static::getTableName())) {
            $oneEntryDatabase = (new Query())
                ->select("*")
                ->from(static::getTableName())
                ->where('id = :id', [':id' => $id])
                ->one();

            $newObject = new static();
            $newObject->scenario = self::SCENARIO_BASIC_FIELDS;

            if (is_array($oneEntryDatabase)) {
                foreach($newObject->activeAttributes() as $key) {
                    $newObject[$key] = $oneEntryDatabase[$key];
                }

                $newObject->setOldAttributes($newObject->attributes);
                $newObject->scenario = self::SCENARIO_DEFAULT;

                return $newObject;
            }
        }

        return false;
    }

    /**
     * Находит все записи таблицы в базе данных,
     * использует static::getTableName()
     * 
     * @return array static::Object
     */
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
                $newObject->scenario = self::SCENARIO_BASIC_FIELDS;
                
                foreach ($newObject->activeAttributes() as $key) {
                    $newObject[$key] = $entry[$key];
                }

                $newObject->setOldAttributes($newObject->attributes);
                $newObject->scenario = self::SCENARIO_DEFAULT;

                $objects[] = $newObject;
            }

            return $objects;
        } else {
            return false;
        }
    }

    /**
     * Сохраняет новую модель в базу данных
     * 
     * @return bool
     */
    public function databaseSave()
    {
        if ($this->validate()) {
            $this->scenario = self::SCENARIO_BASIC_FIELDS;
            $attributes = $this->getAttributes($this->activeAttributes());
            $this->scenario = self::SCENARIO_DEFAULT;
            
            try {
                $transaction = Yii::$app->db->beginTransaction();
                $query = Yii::$app->db
                    ->createCommand()
                    ->insert(static::getTableName(), $attributes)
                    ->execute();

                if ($query) {
                    $this->id = Yii::$app->db->getLastInsertID();
                    $transaction->commit();
                    return $query;
                } else {
                    $transaction->rollback();
                }
            } catch (Exception $e) {
                $transaction->rollback();
                return false;
            }
        } else {
            return false;
        }
    }

    /**
     * Обновляет запись в базе данных на основе модели и её ID
     * 
     * @return bool
     */
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

    /**
     * Удаляет запись из базы данных на основе модели и её ID
     * 
     * @return bool
     */
    public function databaseDelete()
    {
        $query = Yii::$app->db
            ->createCommand()
            ->delete(static::getTableName(), 'id=' . $this->id)
            ->execute();

        return $query;
    }

    /**
     * Находит все записи в таблице базы данных, удовлетворяющие условию
     * использует static::getTableName()
     * 
     * @param string     $field Поле в таблице
     * @param string     $sign  Знак сравнения (>, <, >=, <=, =)
     * @param string|int $value Значение
     * 
     * @return bool
     */
    public static function databaseFindAll($field, $sign, $value)
    {
        $classFields = static::getFieldsList();

        if (
            is_string($field) && in_array($field, $classFields, true) &&
            is_string($sign) && (strlen($sign) == 1 &&
            preg_match("/['=','>','<','>=','<=']/", $sign))
            ) {
            $query = (new Query())
                ->select("*")
                ->from(static::getTableName())
                ->where(
                    $field . $sign . ":value", [
                        ':value' => $value,
                    ])
                ->all();

            return $query;
        }

        return false;
    }

    /**
     * Находит одну запись в таблице базы данных, удовлетворяющую условию
     * использует static::getTableName()
     * 
     * @param string     $field Поле в таблице
     * @param string     $sign  Знак сравнения (>, <, >=, <=, =)
     * @param string|int $value Значение
     * 
     * @return bool
     */
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