<?php
use yii\helpers\Url;
use yii\helpers\Html;

/**
 * @var \yuncms\article\models\Article $tags
 */
?>
<div class="widget-box mt-30">
    <h2 class="widget-box-title"><?= Yii::t('article', 'Hot list') ?>
        <a href="<?= Url::to(['/article/article/index']) ?>" title="<?= Yii::t('article', 'More') ?>">»</a>
    </h2>
    <ol class="widget-top10">
        <?php
        foreach ($models as $model):?>
            <li class="text-muted">
                <a href="<?= Url::to(['/article/article/view', 'uuid' => $model->uuid]) ?>"
                   class="ellipsis"><?= Html::encode($model->title) ?></a>
                <span class="text-muted pull-right"><?= $model->views ?></span>
            </li>
        <?php endforeach; ?>
    </ol>
</div>