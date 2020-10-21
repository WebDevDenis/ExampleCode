<?php


namespace frontend\modules\crm\modules\appeal\services\accessAppeal;
use frontend\modules\access\services\AccessControlNotificationServices;
use frontend\modules\access\repository\AccessGroupRepository;
use frontend\modules\org\repository\OrgDepartmentRepository;
use frontend\modules\org\repository\OrgUsers;
use yii\helpers\Url;

class AccessAppealNotificationServices  extends AccessControlNotificationServices{

	public function post_in_department($postLinks,$value,$accessObject){

		if($postLinks=='post_department_id'){
			if($accessObject->object_data->formName()=='AppealAnswer'){
				$postLinks=$accessObject->object_data->appealItems->post_department_id;
			}else{
				$postLinks=$accessObject->object_data->post_department_id;
			}
		}

		return OrgUsers::getPostInDepartmentUsers($postLinks);
	}

	public function group($groupName){
		return (new AccessGroupRepository())->getUserGroup($groupName);
	}

	public function getModelNotification($accessObject){
		$model = new \stdClass();
		if($accessObject->object_data->formName()=='AppealAnswer'){
			$model->id = $accessObject->object_data->appealItems->id;
			$model->text = $accessObject->object_data->text;
			$model->link='https://sd.mirtechniki.ru/index.php?r=crm%2Fappeal&id='.$accessObject->object_data->appealItems->id;
		}else{
			$model->id = $accessObject->object_data->id;
			$model->text = $accessObject->object_data->text;
			$model->link='https://sd.mirtechniki.ru/index.php?r=crm%2Fappeal&id='.$accessObject->object_data->id;
		}

		return $model;
	}

	public function department($accessObject){
		if($accessObject->object_data->formName()=='AppealAnswer'){
			return OrgDepartmentRepository::getDepartmentUsers($accessObject->object_data->appealItems->department_id);
		}else{
			return OrgDepartmentRepository::getDepartmentUsers($accessObject->object_data->department_id);
		}

	}
	public function responsible($accessObject){
		if($accessObject->object_data->formName()=='AppealAnswer'){
			return $accessObject->object_data->appealItems->user_id;
		}else{
			return $accessObject->object_data->user_id;
		}


	}



}