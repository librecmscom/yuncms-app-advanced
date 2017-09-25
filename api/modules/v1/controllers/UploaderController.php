<?php
/**
 * @link http://www.tintsoft.com/
 * @copyright Copyright (c) 2012 TintSoft Technology Co. Ltd.
 * @license http://www.tintsoft.com/license/
 */

namespace api\modules\v1\controllers;

use Yii;
use yii\web\ServerErrorHttpException;
use api\modules\v1\Controller;
use api\modules\v1\models\UploaderImageForm;

/**
 * Class UploaderController
 * @package api\modules\v1\controllers
 */
class UploaderController extends Controller
{
    /**
     * 图片上传
     * @return UploaderImageForm
     * @throws ServerErrorHttpException
     */
    public function actionImage()
    {
        $model = new UploaderImageForm();
        $model->load(Yii::$app->getRequest()->getBodyParams(), '');
        if ($model->save() != false) {
            $response = Yii::$app->getResponse();
            $response->setStatusCode(201);
            return $model;
        } elseif (!$model->hasErrors()) {
            throw new ServerErrorHttpException('Failed to create the object for unknown reason.');
        }
        return $model;
    }
}