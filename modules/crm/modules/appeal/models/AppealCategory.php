<?php

namespace frontend\modules\crm\modules\appeal\models;

use Yii;

/**
 * This is the model class for table "dkw2t_crm_appeal_category".
 *
 * @property int $id
 * @property string $name
 *
 * @property CrmAppealItems[] $crmAppealItems
 */
class AppealCategory extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'dkw2t_crm_appeal_category';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name'], 'required'],
            [['name'], 'string', 'max' => 255],
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
        return $this->hasMany(CrmAppealItems::className(), ['category' => 'id']);
    }
	public static function getSelectCategory() {
		$categorys =  (new \yii\db\Query())
			->from('dkw2t_crm_appeal_category')
			->all();
		foreach ($categorys as $category) {
			$select[$category['id']] = $category['name'];
		}
		return $select;
	}
}
