<?php

namespace frontend\modules\crm\modules\appeal\models;

use Yii;

/**
 * This is the model class for table "dkw2t_crm_appeal_channel".
 *
 * @property int $id
 * @property string $name
 *
 * @property CrmAppealItems[] $crmAppealItems
 */
class AppealChannel extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'dkw2t_crm_appeal_channel';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name'], 'required'],
            [['name'], 'string'],
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

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCrmAppealItems()
    {
        return $this->hasMany(CrmAppealItems::className(), ['channel' => 'id']);
    }
}
