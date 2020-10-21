<?php

namespace frontend\modules\access;
use yii\helpers\Url;
/**
 * Access module definition class
 */
class access extends \yii\base\Module
{
    /**
     * @inheritdoc
     */
    public $controllerNamespace = 'frontend\modules\access\controllers';

    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();
	    \Yii::configure($this, require(__DIR__ . '/config/config.php'));
        // custom initialization code goes here
    }
}
