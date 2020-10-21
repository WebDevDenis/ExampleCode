<?php

namespace frontend\modules\access\models;

use Yii;

/**
 * This is the model class for table "jwu0a_access_group_link".
 *
 * @property integer $group_id
 * @property integer $data
 */
class GroupLink extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'jwu0a_access_group_link';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['group_id', 'data'], 'required'],
            [['group_id', 'data'], 'integer'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'group_id' => 'Group ID',
            'data' => 'Data',
        ];
    }
}
