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
use api\modules\v1\models\UploaderFileForm;
use api\modules\v1\models\UploaderAudioForm;
use api\modules\v1\models\UploaderImageForm;

/**
 * 文件上传
 * @package api\modules\v1\controllers
 */
class UploaderController extends Controller
{
    /**
     * 图片上传
     * @return UploaderImageForm
     * @throws ServerErrorHttpException
     * @throws \yii\base\InvalidConfigException
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

    /**
     * 语音上传
     * @return UploaderAudioForm
     * @throws ServerErrorHttpException
     * @throws \yii\base\InvalidConfigException
     */
    public function actionAudio()
    {
        $model = new UploaderAudioForm();
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

    /**
     * 文件上传
     * @return UploaderFileForm
     * @throws ServerErrorHttpException
     * @throws \yii\base\InvalidConfigException
     */
    public function actionFile()
    {
        $model = new UploaderFileForm();
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