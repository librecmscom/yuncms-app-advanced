<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\bootstrap\BootstrapAsset;

/**
 * @var yii\web\View $this
 * @var yii\widgets\ActiveForm $form
 * @var yuncms\user\models\User $model
 * @var yuncms\user\models\Social $account
 */
BootstrapAsset::register($this);
$this->title = Yii::t('user', 'Sign in');
//$this->params['breadcrumbs'][] = $this->title;
?>
<div style="width: 100px;height: 100px;text-align: center;font-size: 20px;position: absolute;top: 50px;left: 50%;margin-left: -50px">
    <img src="http://wx.qlogo.cn/mmhead/Q3auHgzwzM4sEibu4a6E6fDRM8oq2OZpW8CVofnpSjE3b5wlSa3dBsQ/0" alt="背景图片" style="width: 100%">
    <strong>OpenEdu</strong>
</div>
<div style="text-align: center;margin-top: 200px;font-size: 14px;color: #888">为了让您体验更多网站功能 <br>请输入邮箱及密码完成网站注册或绑定已有账户</div>
<?php $form = ActiveForm::begin([
    'layout' => 'horizontal',
]); ?>
<?= $form->field($model, 'email') ?>
<?= $form->field($model, 'password', ['inputOptions' => ['autocomplete' => 'off','placeholder'=>"请输入密码"]])->passwordInput()?>
<?= Html::submitButton('注册 & 绑定', ['class' => 'btn btn-success btn-block']) ?>
<script>
    document.getElementById("connectform-email").setAttribute("placeholder", "请输入邮箱");
</script>
<?php ActiveForm::end(); ?>

