<?php

namespace app\controllers;

use app\models\BookSearch;
use Yii;
// use common\ActiveController;
use yii\rest\ActiveController;

/**
 * BookController implements the CRUD actions for Book model.
 */
class BookController extends ActiveController
{
    public $modelClass = 'app\models\Book';

    public  function actions(): array
    {
        $actions = parent::actions();
        // Disable the default actions to customize them
        unset($actions['index'], $actions['view'], $actions['create'], $actions['update'], $actions['delete']);
        return $actions;
    }

    public function actionIndex()
    {
        Yii::info('BookController::actionIndex() called', __METHOD__);
        $searchModel = new BookSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return [
            'status' => 'success',
            'data' => $dataProvider->getModels(),
            'pagination' => [
                'totalCount' => $dataProvider->getTotalCount(),
                'pageSize' => $dataProvider->pagination->pageSize,
                'page' => $dataProvider->pagination->page,
            ],
        ];
    }

    public function actionCreate()
    {
        Yii::info('BookController::actionCreate() called', __METHOD__);
        $model = new $this->modelClass();

        $model->load(Yii::$app->request->post());
        if ($model->save()) {
            return [
                'status' => 'success',
                'data' => $model,
            ];
        } else {
            return [
                'status' => 'error',
                'errors' => $model->getErrors(),
            ];
        }
    }
}
