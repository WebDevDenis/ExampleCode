<?php

namespace frontend\modules\crm\models;

use Yii;

/**
 * This is the model class for table "dkw2t_crm_clients".
 *
 * @property int $id
 * @property string $name
 * @property string $surname
 * @property string $patronymic
 * @property int $date_created
 * @property int $type
 */
class CrmClients extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'dkw2t_crm_clients';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
	        [['name'], 'required'],
            [['name', 'surname', 'patronymic'], 'string'],
            [['date_created', 'type'], 'integer'],
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
            'surname' => 'Surname',
            'patronymic' => 'Patronymic',
            'date_created' => 'Date Created',
            'type' => 'Type',
        ];
    }

	public function getFullName() {
		return $this->surname . ' ' . $this->name . ' ' . $this->patronymic;
	}
	public function getAllType(){
		$select = (new \yii\db\Query())
			->from('dkw2t_crm_clients_type')
			->all();
		$result=[];
		foreach ($select as $item){
			$result[$item['id']] =$item['name'];
		}

		return $result;
	}

}
