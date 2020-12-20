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
                    'info'     => ['get'],
                    'info-all' => ['get'],
                    'find-all' => ['get'],
                    'add'      => ['post'],
                    'edit'     => ['post'],
                    'delete'   => ['post']
                ]
            ]
        ];
    }

    public function actionInfo($id) {
        $output = [];

        try {
            $client = Client::databaseGetOne($id);

            $output['result'] = $client;
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
            $clients = Client::databaseGetAll();

            $output['result'] = $clients;
        } catch (Exception $e) {
            $error = $e->getMessage();

            $output['result'] = false;
            $output['error'] = $error;
        }
        
        return $output;
        //return Client::databaseGetAll();
    }

    public function actionFindAll() {
        $output = [];
        $field = Yii::$app->request->get('field');
        $sign = Yii::$app->request->get('sign');
        $value = Yii::$app->request->get('value');

        try {
            if (!empty($field) && !empty($sign) && ((!empty($value) || ($value === '0') || ($value === '1')))) {
                $clients = Client::databaseFindAll($field, $sign, $value);

                $output['result'] = $clients;
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
        $newClient = new Client();

        try {
            if ($newClient->load($data, '') && $newClient->databaseSave()) {
                $output['result'] = $newClient;
            } else {
                if (empty($data)) {
                    $newClient->validate();
                }

                $output['result'] = false;
                $output['error'] = $newClient->errors;
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
            $client = Client::databaseGetOne($id);

            if (!empty($client)) {
                if ($client->load($data, '') && $client->databaseUpdate()) {
                    $output['result'] = $client;
                } else {
                    $output['result'] = false;
                    $output['error'] = $client->errors;
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
            $client = Client::databaseGetOne($id);

            if (!empty($client)) {
                if ($client->databaseDelete()) {
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