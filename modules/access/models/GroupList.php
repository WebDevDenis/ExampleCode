<?php

namespace frontend\modules\access\models;

use Yii;

/**
 * This is the model class for table "jwu0a_access_group_list".
 *
 * @property integer $id
 * @property string $name
 * @property string $type
 */
class GroupList extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'jwu0a_access_group_list';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'type'], 'required'],
            [['name'], 'string', 'max' => 50],
            [['type'], 'string', 'max' => 100],
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
            'type' => 'Type',
        ];
    }
}
