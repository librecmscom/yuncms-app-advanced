<?php

/* @var $this yii\web\View */

//引入外部JS文件
$this->registerJsFile('/js/im.js');

//给JS排序 position 这行说的是位置 POS_HEAD POS_BEGIN  POS_END
//depends 定义该JS的依赖，如果依赖Jquery,就复制下面的，确保Jq先被加载
$this->registerJsFile('/js/jquery.typetype.js',[
    'position' => \yii\web\View::POS_END,
    'depends'=>[
        'yii\web\YiiAsset',
    ]
]);


//引入外部CSS文件
$this->registerCssFile('/js/im.css');

//在当前页面插入JS片段
$this->registerJs('alert("aaa")');

//在当前页面插入CSS片段
$this->registerCss('body,html{height:100%;}');

?>




//这里是引入JS片段的另一种写法
<?php \yuncms\system\widgets\JsBlock::begin(['pos' => \yii\web\View::POS_END]) ?>
    <script>

    </script>
<?php \yuncms\system\widgets\JsBlock::end() ?>