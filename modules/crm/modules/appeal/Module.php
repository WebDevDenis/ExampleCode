<?php

namespace frontend\modules\crm\modules\appeal;

/**
 * appeal module definition class
 */
class Module extends \yii\base\Module
{
    /**
     * {@inheritdoc}
     */
	public function init()
	{
		parent::init();
		\Yii::configure($this, require(__DIR__ . '/config/config.php'));
	}
}
