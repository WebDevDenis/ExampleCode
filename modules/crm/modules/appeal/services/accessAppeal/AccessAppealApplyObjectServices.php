<?php


namespace frontend\modules\crm\modules\appeal\services\accessAppeal;


use yii\helpers\Url;
use frontend\modules\access\services\AccessControlApplyObjectServices;

class AccessAppealApplyObjectServices extends AccessControlApplyObjectServices{

	function conditions($accessObject) {
		return true;

	}
	public function user_id($accessObject){
		return $accessObject->user_id;
	}


}