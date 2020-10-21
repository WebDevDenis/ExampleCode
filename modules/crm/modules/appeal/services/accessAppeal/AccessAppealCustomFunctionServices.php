<?php


namespace frontend\modules\crm\modules\appeal\services\accessAppeal;

use frontend\modules\access\services\AccessControlCustomFunctionServices;
use frontend\modules\org\repository\OrgDepartmentRepository;
use frontend\modules\notification\services\SendNotificationService;

class AccessAppealCustomFunctionServices extends AccessControlCustomFunctionServices{

	public function sendNoticeDirShop ($accessObject,$paramsFunction){

		if($accessObject->object_data->city_id==null){
			return false;
		}
		if(isset($accessObject->object_data->cityDepartment)){
			foreach ($accessObject->object_data->cityDepartment as $department ){
				$modelMessage = new \stdClass();
				$modelMessage->text = $accessObject->object_data->text;
				$modelMessage->link = 'https://sd.mirtechniki.ru/index.php?r=crm%2Fappeal&id='.$accessObject->object_data->id;
				(new SendNotificationService())->sendOneNotificationToUser('hr_work', OrgDepartmentRepository::getChiefIdForDepartment($department->id),  $modelMessage);
			}
		}

	}

}