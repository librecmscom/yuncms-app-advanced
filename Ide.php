<?php

/**
 * Yii bootstrap file.
 * Used for enhanced IDE code autocompletion.
 */
class Yii extends \yii\BaseYii
{
    /**
     * @var BaseApplication|WebApplication|ConsoleApplication|WeixinApplication the application instance
     */
    public static $app;
}

/**
 * Class BaseApplication
 * Used for properties that are identical for both WebApplication and ConsoleApplication
 *
 * @property xutl\aliyun\Aliyun $aliyun The aliyun component. This property is read-only. Extended component.
 * @property yuncms\core\components\Settings $settings The settings component. This property is read-only. Extended component.
 * @property yii\web\UrlManager $frontUrlManager The frontUrlManager component. This property is read-only. Extended component.
 * @property yii\queue\cli\Queue $queue The queue component. This property is read-only. Extended component.
 * @property xutl\tim\Tim $im The im component. This property is read-only. Extended component.
 * @property xutl\aliyun\Live $live The live component. This property is read-only. Extended component.
 * @property xutl\broadcast\Broadcast $broadcast The broadcast component. This property is read-only. Extended component.
 * @property xutl\payment\Payment $payment The payment component. This property is read-only. Extended component.
 * @property xutl\id98\Id98 $id98 The id98 component. This property is read-only. Extended component.
 */
abstract class BaseApplication extends yii\base\Application
{
}

/**
 * Class WebApplication
 * Include only Web application related components here
 *
 * @property yii\web\UrlManager $frontUrlManager The frontUrlManager component. This property is read-only. Extended component.
 * @property \app\components\MyResponse $response The response component. This property is read-only. Extended component.
 * @property \app\components\ErrorHandler $errorHandler The error handler application component. This property is read-only. Extended component.
 */
class WebApplication extends yii\web\Application
{
}

/**
 * Class ConsoleApplication
 * Include only Console application related components here
 *
 * @property \app\components\ConsoleUser $user The user component. This property is read-only. Extended component.
 */
class ConsoleApplication extends yii\console\Application
{
}
