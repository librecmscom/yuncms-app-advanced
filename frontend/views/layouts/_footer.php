<?php
/* @var $this \yii\web\View */
?>
<footer class="footer">
    <div class="container">
        <p class="pull-left"><?=Yii::$app->settings->get('copyright', 'system')?></p>
        <p class="pull-right"><?= Yii::powered() ?></p>
    </div>
</footer>