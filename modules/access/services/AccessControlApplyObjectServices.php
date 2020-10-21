<?php


namespace frontend\modules\access\services;
use frontend\modules\access\repository\AccessArhistoryRepository;


class AccessControlApplyObjectServices  {

	public function Apply($accessObject){
		$action_button = json_decode($accessObject->action->action_button);

		if (!empty($action_button->EditDataObject)) {

			foreach ($action_button->EditDataObject as $key => $value) {

				if (AccessControlHelperServices::functionCheck($value)){
					$nameFunction = AccessControlHelperServices::getNameFunction($value);
					$paramsFunction = AccessControlHelperServices::getFunctionParam($value);
					$value= $this->{$nameFunction}($accessObject,$paramsFunction);
				}
				if (isset($accessObject->updateDataObject[$value]) && $accessObject->object_data->{$value} != (int)$accessObject->updateDataObject[$value]) {
					$value = $accessObject->updateDataObject[$value];
				}
				$accessObject->object_data->{$key} = $value;
			}

		}

		if(isset($accessObject->action->after_condition_data) && $accessObject->action->after_condition_data !=''){
			if(!$this->ConditionAfterApply($accessObject)){
				return false;
			}
		}
		if(property_exists($accessObject->object_data::className(),'access_action')  ){//&& isset($accessObject->getActionList()->id)
			$accessObject->object_data->access_action= $accessObject->getActionList()->id;
		}


		if (!$accessObject->object_data->save()) {
			\Yii::error('Ошибка при обновлении задачи:()', 'update_tables');
			throw new \Exception('Ошибка при сохранении. Обратитесь к web-программисту');
		}

		return true;

	}

	public function ConditionAfterApply($accessObject){

		$after_condition = json_decode($accessObject->action->after_condition_data);

		$access = (new AccessControlHelperServices())->DataComparison($after_condition,$accessObject->object_data,$accessObject);

		if(!$access){
			return false;
		}
		\Yii::$app->session->setFlash('success', 'Сохранено');
		return true;
	}


}