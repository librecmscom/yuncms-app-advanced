<?php
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ListView;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */
$this->title = Yii::t('app', 'Topic');
?>
<div class="row">
    <div class="col-md-12">
        <div class="page-header">
            <h4>
                <i class="glyphicon glyphicon-tags"></i> <?= Html::encode($this->title) ?>
                <small><?= Yii::t('app', 'Topics can not only organize and categorize your content, but also link similar content. Correct use of the topic will make your problem more people find and solve.') ?></small>
            </h4>
        </div>
        <?=
        ListView::widget([
            'options' => [
                'class' => 'row tag-list'
            ],
            'layout' => '{items} <div class="text-center">{pager}</div>',
            'pager' => [
                'maxButtonCount' => 10,
                'nextPageLabel' => Yii::t('app', 'Next page'),
                'prevPageLabel' => Yii::t('app', 'Previous page'),
            ],
            'dataProvider' => $dataProvider,
            'itemView' => '_item'
        ]);
        ?>
    </div>
</div>

