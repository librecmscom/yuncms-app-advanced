<?php
/**
 * @link http://www.tintsoft.com/
 * @copyright Copyright (c) 2012 TintSoft Technology Co. Ltd.
 * @license http://www.tintsoft.com/license/
 */

namespace frontend\controllers;

use yii\web\Controller;

/**
 * 法律条款
 * @package frontend\controllers
 */
class LegalController extends Controller
{
    /**
     * Displays Privacy page.
     *
     * @return mixed
     */
    public function actionPrivacy()
    {
        return $this->render('privacy');
    }

    /**
     * Displays Terms of Use page.
     *
     * @return mixed
     */
    public function actionTerms()
    {
        return $this->render('terms');
    }

    /**
     * Displays logo page.
     *
     * @return mixed
     */
    public function actionLogo()
    {
        return $this->render('logo');
    }

    /**
     * Displays Copyright page.
     *
     * @return mixed
     */
    public function actionCopyright()
    {
        return $this->render('copyright');
    }
}