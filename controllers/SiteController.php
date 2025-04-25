<?php

namespace app\controllers;

use Yii;
use yii\web\Controller;
use yii\web\Response;

class SiteController extends Controller
{
    public function actionIndex()
    {
        Yii::$app->response->format = Response::FORMAT_JSON;
        return ['message' => 'API is working', 'status' => 'success'];
    }

    public function actionError()
    {
        Yii::$app->response->format = Response::FORMAT_JSON;
        $exception = Yii::$app->errorHandler->exception;
        return [
            'name' =>  'Error',
            'message' => $exception ? $exception->getMessage() : 'An error occurred.',
            'code' => $exception ? $exception->statusCode : 500,
        ];
    }
}
