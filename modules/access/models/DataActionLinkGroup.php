<?php

namespace frontend\modules\access\models;

use Yii;

/**
 * This is the model class for table "jwu0a_access_data_action_link_group".
 *
 * @property integer $group_id
 * @property integer $data_action_id
 * @property integer $switch
 * @property string $rights
 * @property string $data
 */
class DataActionLinkGroup extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'jwu0a_access_data_action_link_group';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['group_id', 'data_action_id', 'switch', 'rights', 'data'], 'required'],
            [['group_id', 'data_action_id', 'switch'], 'integer'],
            [['rights', 'data'], 'string', 'max' => 50],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'group_id' => 'Group ID',
            'data_action_id' => 'Data Action ID',
            'switch' => 'Switch',
            'rights' => 'Rights',
            'data' => 'Data',
        ];
    }
}
