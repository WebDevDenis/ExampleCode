<?php


namespace frontend\modules\access\services;
use frontend\modules\access\repository\AccessArhistoryRepository;
use frontend\modules\access\services\AccessControlHelperServices;


class AccessControlCustomFunctionServices  {

	public function CheckAndApply($accessObject){
		$action_button = json_decode($accessObject->action->action_button);

		if (!empty($action_button->customFunction)) {
			if(AccessControlHelperServices::functionCheck($action_button->customFunction)){
				$nameFunction = AccessControlHelperServices::getNameFunction($action_button->customFunction);
				$paramsFunction = AccessControlHelperServices::getFunctionParam($action_button->customFunction);
				return $this->{$nameFunction}($accessObject,$paramsFunction);
			}
		}
		return false;
	}




}