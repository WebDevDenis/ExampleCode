<?php
namespace frontend\modules\access\components;

use frontend\modules\access\models\AccessControl;
use  frontend\modules\access\models\ActionList;


class CAccessAction  extends \yii\base\Object  {

	public $accessObject;


	/**
	 * @param string $access
	 */
	public function setAccessObject(string $access) {
		if($this->accessObject){
			return $this->accessObject;
		}
		$this->accessObject = AccessControl::model($access);
	}

	/**
	 * @param $action
	 *
	 * @return mixed
	 */
	public function baseAccess($action) {
		$ActionList= ActionList::getActionList($action);

		$this->setAccessObject($ActionList->module);
		$this->accessObject->setActionList($ActionList);

	}




	/**
	 * Подключение прав
	 *
	 * Функция проверяет наличие доступа к конкретному действию.
	 * Это компанент для подключения в коде, ещё есть DefaultController который тоже как-то проверяет ...
	 *
	 * @param $action действие, которое запрашивается на проверку
	 * @param $object - модель сущности
	 * @param $id - id модели
	 * @param bool|array $data массив с данными, по которым будет проверяться условие прав
	 *
	 * @return bool
	 */

	public function applyAction($action,$object=false, $id=false,$updateData=false) {

		 $this->baseAccess($action);

		if($object){
			$this->accessObject->setObjectData($object);

		}elseif($id){
			$this->accessObject->setObjectId($id);
			$this->accessObject->createObjectData($id);
		}

		if ($updateData){
			$this->accessObject->setUpdateDataObject($updateData);
		}

		$access = $this->accessObject->check_action($action);

		if ($access) {
			$this->accessObject->ActionObject();
			return true;
		}
		return false;

	}
	/**
	 * Проверка прав на действие и получение дополнительных данных
	 *
	 * Функция проверяет наличие доступа к конкретному действию и возвращает дополнительные данные
	 *
	 * @param string $action - действие, по которому нужно получить данные
	 *
	 * @return array массив данных с поля data из таблицы jwu0a_access_data_action
	 * @throws \Exception
	 */
	public function actionData($action) {
		$this->baseAccess($action);
		$access = $this->accessObject->check_action($action);
		if($access){
			return $this->accessObject->getDataAction();
		}
		return false;
	}

	/**
	 * Проверка прав без сущности
	 *
	 * @param string $action - действие которое нужно проверить на доступ
	 *
	 * @return bool true или false
	 * @throws \Exception
	 */
	public function actionCheck(string $action) {

		$this->baseAccess($action);
		return $this->accessObject->check_action($action);

	}


}