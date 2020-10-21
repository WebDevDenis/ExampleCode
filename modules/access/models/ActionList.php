<?php

namespace frontend\modules\access\models;

use Yii;

/**
 * This is the model class for table "jwu0a_access_action_list".
 *
 * @property integer $id
 * @property string $name
 * @property string $system_name
 * @property string $com
 * @property string $object
 */
class ActionList extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */

    public static function tableName()
    {
        return 'jwu0a_access_action_list';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'system_name', 'module', 'object'], 'required'],
            [['object'], 'string'],
            [['name', 'system_name', 'module'], 'string', 'max' => 50],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
            'system_name' => 'System Name',
            'module' => 'module',
            'object' => 'Object',
        ];
    }

	/**
	 * @param string $system_name
	 *
	 * @return array|\yii\db\ActiveRecord|null
	 */
	public static function getActionList(string $system_name) {
    	return self::find()->where('system_name="' .  $system_name . '"')
	               ->one();

	}
}
