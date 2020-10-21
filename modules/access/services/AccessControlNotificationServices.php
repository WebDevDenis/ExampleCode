<?php


namespace frontend\modules\access\services;

use frontend\modules\notification\services\SendNotificationService;

class AccessControlNotificationServices {

	public function sendNotification($accessObject){
		$action_button = json_decode($accessObject->action->action_button);

		if (isset($action_button->notice)) {

			foreach ($action_button->notice as $key => $value) {

				if(strripos($key,'(')){
					$data = substr(substr("$key", strripos($key,'('), strripos($key,')')), 1, -1);
					$function=substr("$key",0,  strripos($key,'('));

					$user_id = $this->{$function}($data,$value,$accessObject);
				}else{
					$user_id = $this->{$key}($accessObject,$value);
				}



				if ($user_id==false){continue;}
				if (is_array($user_id)) {
					foreach ($user_id as $key => $user){
						$user_id[$key]=$user['user_id'];
					}
				}
				$model = $this->getModelNotification($accessObject);

				if(!is_array($value)){
					(new SendNotificationService())->sendOneNotificationToUser($value, $user_id, $model, null,true);
				}else{
					foreach ($value as $template) {
						(new SendNotificationService())->sendOneNotificationToUser($template, $user_id, $model,null,true);
					}
				}
			}
		}
	}



}