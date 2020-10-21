<?php

namespace frontend\modules\crm;

/**
 * crm module definition class
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
