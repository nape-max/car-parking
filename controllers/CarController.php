<?php

namespace app\controllers;

use Yii;
use yii\rest\Controller;
use yii\web\Response;
use yii\filters\VerbFilter;

use app\models\Car;

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

    public function actionAdd() {
        return 'add';
    }

    public function actionEdit($id) {
        return $id;
    }

    public function actionDelete($id) {
        return $id;
    }
}