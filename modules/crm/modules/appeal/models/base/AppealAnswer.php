<?php

namespace frontend\modules\crm\modules\appeal\models\base;

use frontend\modules\crm\modules\appeal\models\AppealChannel;
use frontend\modules\crm\modules\appeal\references\AnswerReferences;

use dektrium\user\models\User;
use frontend\modules\crm\modules\appeal\models\AppealItems;

/**
 * This is the model class for table "{{%crm_appeal_answer}}".
 *
 * @property int $id
 * @property int $id_appeal
 * @property int $id_author
 * @property int $id_client
 * @property string $text
 * @property int $chanel
 * @property int $date_created
 * @property int $date_sending
 */
class AppealAnswer extends \yii\db\ActiveRecord
{
	public  $module='appeal';
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%crm_appeal_answer}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id_appeal', 'id_author', 'id_client', 'chanel', 'date_created', 'date_sending', 'read_email', 'read_sms', 'status_sms' ], 'integer'],
	        [['date_sending'], 'integer'],
            [['email_id'], 'string', 'max' => 250],
            [['text'], 'string'],
	        [['text'], 'required'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'id_appeal' => 'Id Appeal',
            'id_author' => 'Id Author',
            'id_client' => 'Id Client',
            'text' => 'Text',
            'chanel' => 'Chanel',
            'date_created' => 'Date Created',
            'read_sms' => 'read_sms',
            'status_sms' => 'status_sms',
        ];
    }

    public function getAppealItems()
    {
        return $this->hasOne(AppealItems::className(), ['id' => 'id_appeal']);
    }

    public function getChildModel(){
        return new AnswerReferences::$entiteObj[$this->chanel]();

    }
	public function getAuthor()
	{
		return $this->hasOne(User::className(), ['id' => 'id_author']);
	}
	public function getChanelInfo()
	{
		return $this->hasOne(AppealChannel::className(), ['id' => 'chanel']);
	}
}
