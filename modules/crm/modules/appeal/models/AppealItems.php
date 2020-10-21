<?php

namespace frontend\modules\crm\modules\appeal\models;

use Yii;

use frontend\modules\task\models\Task;
use frontend\modules\crm\models\CrmClients;
use dektrium\user\models\User;
use frontend\modules\org\models\Departments;
use frontend\modules\crm\modules\appeal\models\base\AppealAnswer;
/**
 * This is the model class for table "dkw2t_appeal_items".
 *
 * @property int $id
 * @property int $channel
 * @property int $category
 * @property string $text
 * @property string $title
 * @property int $user_id
 * @property int $client_id
 * @property string $email
 * @property int $phone
 * @property int $created_date
 * @property int $status
 * @property int $department_id
 * @property int $post_department_id
 */

class AppealItems extends \yii\db\ActiveRecord
{
	public $last_active;
	public  $module='appeal';
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'dkw2t_crm_appeal_items';
    }

	/**
	 * {@inheritdoc}
	 */
	public function rules()
	{
		return [
			[['channel', 'category', 'text', 'title', 'created_date', 'status'], 'required'],
			[['channel', 'category', 'user_id', 'client_id', 'created_date', 'status', 'department_id', 'post_department_id','city_id'], 'integer'],
			[['text'], 'string'],
			[['title'], 'string', 'max' => 100],
			[['email', 'phone'], 'string', 'max' => 50],
			[['channel'], 'exist', 'skipOnError' => true, 'targetClass' => AppealChannel::className(), 'targetAttribute' => ['channel' => 'id']],
			[['category'], 'exist', 'skipOnError' => true, 'targetClass' => AppealCategory::className(), 'targetAttribute' => ['category' => 'id']],
		];
	}

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'Номер обращения',
            'channel' => 'Канал',
            'category' => 'Категория',
            'text' => 'Текст',
            'title' => 'Тема',
            'user_id' => 'Ответственный',
            'client_id' => 'Клиент',
            'email' => 'email',
            'phone' => 'Телефон',
            'created_date' => 'Дата создания',
            'status' => 'Статус',
            'department_id' => 'Ответственный отдел',
            'post_department_id' => 'Ответственная должность',
        ];
    }
	public function getAllDepUsers() {
		return (new Task)->getAllDepUsers();
	}

	public function getDepartment(){
		return (new Task)->getOptiondepartment();
	}
	public function getPostsCreated(){
		return (new Task)->getPostsCreated();
	}
	public function getClientUser()
	{
		return $this->hasOne(CrmClients::className(), ['id' => 'client_id']);
	}
	public function getDepartments()
	{
		return $this->hasOne(Departments::className(), ['id' => 'department_id']);
	}
	public function getCityDepartment()
	{
		return $this->hasMany(Departments::className(), ['city_id' => 'city_id']);
	}
	public function getUsers()
	{
		return $this->hasOne(User::className(), ['id' => 'user_id']);
	}
	public function getAppealStatus()
	{
		return $this->hasOne(AppealStatus::className(), ['id' => 'status']);
	}
	public function getAppealChannel()
	{
		return $this->hasOne(AppealChannel::className(), ['id' => 'channel']);
	}
	public function getAnswers() {
        return $this->hasMany(AppealAnswer::className(), ['id_appeal' => 'id']);
    }

	public function getAppealCategory()
	{
		return $this->hasOne(AppealCategory::className(), ['id' => 'category']);
	}
	public function getSelectCategory() {
		return AppealCategory::getSelectCategory();
	}


}
