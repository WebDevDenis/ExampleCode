<?php

namespace frontend\modules\access\models;

use Yii;

/**
 * This is the model class for table "jwu0a_access_data_action".
 *
 * @property integer $id
 * @property string $data
 * @property integer $action_id
 * @property string $rights
 * @property string $com
 * @property integer $priority
 * @property string $action_button
 */
class DataAction extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'jwu0a_access_data_action';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['data', 'action_id', 'rights', 'com', 'priority', 'action_button'], 'required'],
            [['data', 'action_button'], 'string'],
            [['action_id', 'priority'], 'integer'],
            [['rights'], 'string', 'max' => 50],
            [['com'], 'string', 'max' => 20],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'data' => 'Data',
            'action_id' => 'Action ID',
            'rights' => 'Rights',
            'com' => 'Com',
            'priority' => 'Priority',
            'action_button' => 'Action Button',
        ];
    }
      public function getActionList()
    {
        return $this->hasMany(ActionList::className(), ['id' => 'action_id']);
    }
}
