<?php

namespace app\controllers;

use Yii;
use yii\rest\Controller;
use yii\web\Response;
use yii\filters\VerbFilter;
use yii\db\Query;

use app\models\Client;
use app\models\Car;

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
        $output = [];

        try {

        } catch (Exception $e) {
            $error = $e->getMessage();

            $output['result'] = false;
            $output['error'] = $error;
        }
        
        return $output;
        //return Client::databaseGetAll();
    }

    public function actionFind() {
        $output = [];

        try {

        } catch (exception $e) {
            $error = $e->getMessage();

            $output['result'] = false;
            $output['error'] = $error;
        }

        return $output;

        // $car = new Car();
        // $car->id = 1;
        // $car->brand = 'BMW';
        // $car->model = 'X5';
        // $car->color = 'Black';
        // $car->license_plate_number = 'с065мк';
        // $car->is_on_parking = true;
        // $car->client_id = 1;

        // $car->validate();

        // echo print_r($car->errors, true);
        // exit();

        // return 1;
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

        // $client = new Client();

        // $client->id = 2;
        // $client->full_name = "John Patrick";
        // $client->gender = "M";
        // $client->phone = "+71111111111";

        // return $client->databaseUpdate();

        // $query = (new Query())
        //     ->select('')
        //     ->from('client')
        //     ->where('full_name=:full_name', [':full_name' => $full_name])
        //     ->createCommand()
        //     ->getRawSql();

        //return $query;
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