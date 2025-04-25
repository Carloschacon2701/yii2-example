<?php
// common/ActiveController.php
namespace common;

use Yii;
use yii\rest\ActiveController as YiiActiveController;
use yii\web\Response;

/**
 * @param \yii\base\Action $action
 * @param mixed $result
 * @return array|mixed
 */
class ActiveController extends YiiActiveController
{

    public function beforeAction($action)
    {
        Yii::$app->response->format = Response::FORMAT_JSON;
        return parent::beforeAction($action);
    }
    /**
     * @param \yii\base\Action $action
     * @param mixed $result
     * @return array|mixed
     */

    public function afterAction($action, $result)
    {
        if (is_array($result)) {
            return [
                'status' => 'success',
                'data' => $result,
            ];
        } else {
            return parent::afterAction($action, $result);
        }
    }
}
