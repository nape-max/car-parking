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

    public function actionGetOne($id)
    {
        $output = [];

        try {
            $car = Car::databaseGetOne($id);

            $output['result'] = $car;
        } catch (Exception $e) {
            $error = $e->getMessage();

            $output['result'] = false;
            $output['error'] = $error;
        }

        return $output;
    }

    public function actionGetAll()
    {
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

    public function actionAdd() {
        $output = [];

        try {

        } catch (Exception $e) {
            $error = $e->getMessage();

            $output['result'] = false;
            $output['error'] = $error;
        }

        return $output;
    }

    public function actionEdit($id) {
        $output = [];

        try {

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

        } catch (Exception $e) {
            $error = $e->getMessage();

            $output['result'] = false;
            $output['error'] = $error;
        }

        return $output;
    }
}