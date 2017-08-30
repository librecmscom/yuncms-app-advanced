<?php
/**
 * @link http://www.tintsoft.com/
 * @copyright Copyright (c) 2012 TintSoft Technology Co. Ltd.
 * @license http://www.tintsoft.com/license/
 */

namespace api\modules\v1\controllers;

use Yii;
use api\modules\v1\Controller;

/**
 * Class AccountController
 * @package api\modules\v1\controllers
 */
class AccountController extends Controller
{
    /**
     * Returns username and email
     */
    public function actionIndex()
    {
        $user = Yii::$app->user->identity;
        return [
            'id' => $user->id,
            'username' => $user->username,
            'email' => $user->email,
            'mobile' => $user->mobile
        ];
    }
}