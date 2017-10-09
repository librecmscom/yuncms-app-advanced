<?php
/**
 * @link http://www.tintsoft.com/
 * @copyright Copyright (c) 2012 TintSoft Technology Co. Ltd.
 * @license http://www.tintsoft.com/license/
 */

namespace api\modules\v1\controllers;

use api\modules\v1\ActiveController;

/**
 * Class LanguageController
 * @package api\modules\v1\controllers
 */
class LanguageController extends ActiveController
{
    public $modelClass = 'api\modules\v1\models\Language';

    /**
     * 定义API是只读的
     * @return array
     */
    public function actions()
    {
        $actions = parent::actions();
        unset($actions['delete'], $actions['create'], $actions['update']);
        return $actions;
    }
}