<?php

namespace app\controllers;

use Yii;
use yii\rest\Controller;
use yii\web\Response;
use yii\filters\VerbFilter;

use app\models\Car;
use app\models\Client;

class CarController extends Controller
{
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    //'test' => ['get],
                ],
            ]
        ];
    }

    public function actionInfo($id) {
        $output = [];

        try {
            $car = Car::databaseGetOne($id);

            $output['result'] = $car;
        } catch (exception $e) {
            $error = $e->getMessage();

            $output['result'] = false;
            $output['error'] = $error;
        }

        return $output;
    }

    public function actionInfoAll() {
        $output = [];

        try {
            $cars = Car::databaseGetAll();

            $output['result'] = $cars;
        } catch (Exception $e) {
            $error = $e->getMessage();

            $output['result'] = false;
            $output['error'] = $error;
        }
        
        return $output;
    }

    public function actionFindAll() {
        $output = [];
        $field = Yii::$app->request->get('field');
        $sign = Yii::$app->request->get('sign');
        $value = Yii::$app->request->get('value');

        try {
            if (!empty($field) && !empty($sign) && !empty($value)) {
                $cars = Car::databaseFindAll($field, $sign, $value);

                $output['result'] = $cars;
            } else {
                $output['result'] = false;
                $output['error'] = "'field', 'sign', 'value' get parameters must be specified.";
            }
        } catch (exception $e) {
            $error = $e->getMessage();

            $output['result'] = false;
            $output['error'] = $error;
        }

        return $output;
    }

    public function actionAdd() {
        $output = [];
        $data = Yii::$app->request->post();
        $newCar = new Car();

        try {
            if ($newCar->load($data, '') && $newCar->databaseSave()) {
                $output['result'] = $newCar;
            } else {
                $output['result'] = false;
                $output['error'] = $newCar->errors;
            }
        } catch (Exception $e) {
            $error = $e->getMessage();

            $output['result'] = false;
            $output['error'] = $error;
        }

        return $output;
    }

    public function actionEdit($id) {
        $output = [];
        $data = Yii::$app->request->post();

        try {
            $car = Car::databaseGetOne($id);

            if (!empty($car)) {
                if ($car->load($data, '') && $car->databaseUpdate()) {
                    $output['result'] = $car;
                } else {
                    $output['result'] = false;
                    $output['error'] = $car->errors;
                }
            } else {
                $output['result'] = false;
                $output['error'] = 'Cannot find entry with that id.';
            }

        } catch (Exception $e) {
            $error = $e->getMessage();

            $output['result'] = false;
            $output['error'] = $error;
        }

        return $output;
    }

    public function actionDelete($id) {
        $output = [];

        try {
            $car = Car::databaseGetOne($id);

            if (!empty($car)) {
                if ($car->databaseDelete()) {
                    $output['result'] = true;
                } else {
                    $output['result'] = false;
                }
            } else {
                $output['result'] = false;
                $output['error'] = 'Cannot find entry with that id.';
            }
        } catch (Exception $e) {
            $error = $e->getMessage();

            $output['result'] = false;
            $output['error'] = $error;
        }

        return $output;
    }
}