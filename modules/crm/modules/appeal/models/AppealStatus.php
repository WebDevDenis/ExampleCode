<?php

namespace frontend\modules\crm\modules\appeal\models;

use Yii;

/**
 * This is the model class for table "dkw2t_crm_appeal_status".
 *
 * @property int $id
 * @property string $name
 */
class AppealStatus extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'dkw2t_crm_appeal_status';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name'], 'required'],
            [['name'], 'string', 'max' => 100],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
        ];
    }
}
