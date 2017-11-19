<?php
/**
 * @link http://www.tintsoft.com/
 * @copyright Copyright (c) 2012 TintSoft Technology Co. Ltd.
 * @license http://www.tintsoft.com/license/
 */

namespace api\modules\v1\controllers;

use Yii;
use yii\web\ForbiddenHttpException;
use api\modules\v1\ActiveController;

/**
 * Class PaymentController
 * @package api\modules\v1\controllers
 */
class PaymentController extends ActiveController
{
    public $modelClass = 'api\modules\v1\models\Payment';


    public function actionClose()
    {

    }

    public function actionRefund()
    {

    }

    public function actionRefundQuery()
    {

    }

    /**
     * ��鵱ǰ�û���Ȩ��
     *
     * This method should be overridden to check whether the current user has the privilege
     * to run the specified action against the specified data model.
     * If the user does not have access, a [[ForbiddenHttpException]] should be thrown.
     *
     * @param string $action the ID of the action to be executed
     * @param object $model the model to be accessed. If null, it means no specific model is being accessed.
     * @param array $params additional parameters
     * @throws ForbiddenHttpException if the user does not have access
     */
    public function checkAccess($action, $model = null, $params = [])
    {
        if ($action === 'update' || $action === 'delete') {
            if ($model->user_id !== Yii::$app->user->id) {
                throw new ForbiddenHttpException(sprintf('You can only %s articles that you\'ve created.', $action));
            }
        }
    }
}