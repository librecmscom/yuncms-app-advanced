<?php
/**
 * @link http://www.tintsoft.com/
 * @copyright Copyright (c) 2012 TintSoft Technology Co. Ltd.
 * @license http://www.tintsoft.com/license/
 */

namespace api\modules\v1\models;

use api\models\User;
use Yii;
use yii\base\Model;
use yii\imagine\Image;
use yii\web\UploadedFile;
use yuncms\user\UserTrait;

/**
 * Class AvatarForm
 * @package api\modules\v1\models
 */
class AvatarForm extends Model
{
    use UserTrait;

    /**
     * @var \yii\web\UploadedFile 头像上传字段
     */
    public $file;

    /**
     * @var \yuncms\user\models\User
     */
    private $_user;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['file'], 'required'],
            [['file'], 'file', 'extensions' => 'gif, jpg, png', 'maxSize' => 1024 * 1024 * 2, 'tooBig' => Yii::t('user', 'File has to be smaller than 2MB')],
        ];
    }

    /**
     * 保存头像
     *
     * @return boolean
     */
    public function save()
    {
        if ($this->validate()) {
            $user = $this->getUser();
            $avatarPath = $this->getAvatarPath($user->id);
            $originalImage = $avatarPath . '_avatar.jpg';

            //保存原图
            $this->file->saveAs($originalImage);

            //缩放
            Image::thumbnail($originalImage, 200, 200)->save($avatarPath . '_avatar_big.jpg', ['quality' => 100]);
            Image::thumbnail($avatarPath . '_avatar_big.jpg', 128, 128)->save($avatarPath . '_avatar_middle.jpg', ['quality' => 100]);
            Image::thumbnail($avatarPath . '_avatar_big.jpg', 48, 48)->save($avatarPath . '_avatar_small.jpg', ['quality' => 100]);
            $user->avatar = true;
            $user->save();
            return $user;
        }
        return false;
    }

    public function beforeValidate()
    {
        $this->file = UploadedFile::getInstanceByName('file');
        return parent::beforeValidate();
    }

    /*
     * @return User
     */
    public function getUser()
    {
        if ($this->_user == null) {
            $this->_user = User::findOne(Yii::$app->user->identity->id);
        }
        return $this->_user;
    }


}