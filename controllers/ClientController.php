<?php

namespace app\controllers;

use Yii;
use yii\rest\Controller;
use yii\web\Response;
use yii\filters\VerbFilter;
use yii\db\Query;

use app\models\Client;

class ClientController extends Controller
{
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    //'test' => ['get'],
                ]
            ]
        ];
    }

    public function actionGetAll() {
        return Client::databaseGetAll();
    }

    public function actionAdd() {
        $client = new Client();

        $client->id = 2;
        $client->full_name = "John Patrick";
        $client->gender = "M";
        $client->phone = "+71111111111";

        return $client->databaseUpdate();

        // $query = (new Query())
        //     ->select('')
        //     ->from('client')
        //     ->where('full_name=:full_name', [':full_name' => $full_name])
        //     ->createCommand()
        //     ->getRawSql();

        //return $query;
    }

    public function actionEdit($id) {
    
    }

    public function actionDelete($id) {

    }
}