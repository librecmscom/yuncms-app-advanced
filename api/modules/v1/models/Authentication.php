<?php
/**
 * @link http://www.tintsoft.com/
 * @copyright Copyright (c) 2012 TintSoft Technology Co. Ltd.
 * @license http://www.tintsoft.com/license/
 */

namespace api\modules\v1\models;

use Yii;
use yii\helpers\ArrayHelper;
use yii\web\UploadedFile;
use yuncms\system\validators\IdCardValidator;

/**
 * Class Authentication
 * @package api\modules\v1\models
 */
class  Authentication extends \yuncms\authentication\models\Authentication
{
    /**
     * @var \yii\web\UploadedFile 身份证上传字段
     */
    public $id_file;

    /**
     * @var \yii\web\UploadedFile 身份证上传字段
     */
    public $id_file1;

    /**
     * @var \yii\web\UploadedFile 身份证上传字段
     */
    public $id_file2;

    /**
     * @var bool 是否同意注册协议
     */
    public $registrationPolicy;

    /**
     * 屏蔽敏感字段
     * @return array
     */
    public function fields()
    {
        $fields = parent::fields();

        // 删除一些包含敏感信息的字段
        unset($fields['passport_cover'], $fields['passport_person_page'], $fields['passport_self_holding']);

        return $fields;
    }

    /**
     * @inheritdoc
     */
    public function scenarios()
    {
        $scenarios = parent::scenarios();
        return ArrayHelper::merge($scenarios, [
            self::SCENARIO_CREATE => ['real_name', 'id_type', 'id_card', 'id_file', 'id_file1', 'id_file2'],
            self::SCENARIO_UPDATE => ['real_name', 'id_type', 'id_card', 'id_file', 'id_file1', 'id_file2'],
        ]);
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        $rules = parent::rules();
        return array_merge($rules, [
            'idFileRequired' => [
                ['id_file', 'id_file1', 'id_file2'],
                'required',
                'on' => [self::SCENARIO_CREATE, self::SCENARIO_UPDATE]
            ],

            'idFileFile' => [
                ['id_file', 'id_file1', 'id_file2'], 'file',
                'extensions' => 'gif,jpg,jpeg,png',
                'maxSize' => 1024 * 1024 * 2,
                'tooBig' => Yii::t('authentication', 'File has to be smaller than 2MB'),
                'on' => [self::SCENARIO_CREATE, self::SCENARIO_UPDATE]
            ],

            'registrationPolicyRequired' => [
                'registrationPolicy',
                'required',
                'skipOnEmpty' => false,
                'requiredValue' => true,
                'message' => Yii::t('authentication', '{attribute} must be selected.')
            ],
        ]);
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        $attributeLabels = parent::attributeLabels();
        return array_merge($attributeLabels, [
            'id_file' => Yii::t('authentication', 'Passport cover'),
            'id_file1' => Yii::t('authentication', 'Passport person page'),
            'id_file2' => Yii::t('authentication', 'Passport self holding'),
            'registrationPolicy' => Yii::t('authentication', 'Agree and accept Service Agreement and Privacy Policy'),
        ]);
    }

    /**
     * @param bool $insert
     * @return bool
     */
    public function beforeSave($insert)
    {
        if (parent::beforeSave($insert)) {
            $idCardPath = $this->getIdCardPath($this->user_id);
            if ($this->id_file && $this->id_file->saveAs($idCardPath . '_passport_cover_image.jpg')) {
                $this->passport_cover = $this->getIdCardUrl($this->user_id) . '_passport_cover_image.jpg';
            }
            if ($this->id_file1 && $this->id_file1->saveAs($idCardPath . '_passport_person_page_image.jpg')) {
                $this->passport_person_page = $this->getIdCardUrl($this->user_id) . '_passport_person_page_image.jpg';
            }
            if ($this->id_file2 && $this->id_file2->saveAs($idCardPath . '_passport_self_holding_image.jpg')) {
                $this->passport_self_holding = $this->getIdCardUrl($this->user_id) . '_passport_self_holding_image.jpg';
            }
            if (!$insert && $this->scenario == 'update') {
                $this->status = self::STATUS_PENDING;
            }
            return true;
        } else {
            return false;
        }
    }

    /**
     * 加载上传文件
     * @return bool
     */
    public function beforeValidate()
    {
        $this->id_file = UploadedFile::getInstanceByName('id_file');
        $this->id_file1 = UploadedFile::getInstanceByName('id_file1');
        $this->id_file2 = UploadedFile::getInstanceByName('id_file2');
        return parent::beforeValidate();
    }
}