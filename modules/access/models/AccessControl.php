<?php

namespace frontend\modules\access\models;
use  frontend\modules\access\repository\AccessDataActionRepository;
use  frontend\modules\access\repository\AccessGroupRepository;
use  frontend\modules\access\services\AccessControlHelperServices;

class AccessControl extends  \yii\base\Component
{
	protected $applyObjectServices ="frontend\modules\access\services\AccessControlApplyObjectServices";
	protected $NotificationServices ="frontend\modules\access\services\AccessControlNotificationServices";
	protected $AfterApplyObjectServices ="frontend\modules\access\services\AccessControlAfterApplyObjectServices";
	protected $CustomFunctionServices ="frontend\modules\access\services\AccessControlCustomFunctionServices";


	/**
	 * @var
	 */
	var $user_id;
	/**
	 * @var действие, которое прошло проверку прав
	 */
	var $action;
	/**
	 * @var
	 */
	var $objectId;
	/**
	 * @var array массив данных, для обновления модели сущности
	 */
	protected $updateDataObject;
	/**
	 * @var AR model
	 */
	var $object_data;


	private $ActionList;
	private $AccessGroupRepository;


	/**
	 * @param $data
	 */
	function setObjectId($data){
		$this->objectId = $data;
	}
	/**
	 * @return array
	 */
	function getAfterApplyObjectServices(){
		return $this->AfterApplyObjectServices;
	}

	/**
	 * @return array
	 */
	function getObjectId(){
		return $this->updateDataObject;
	}

	/**
	 * @param $data
	 */
	function setUpdateDataObject($updateData){
		$this->updateDataObject = $updateData;
	}

	/**
	 * @return array
	 */
	function getUpdateDataObject(){
		return $this->updateDataObject;
	}

	/**
	 * @param $object
	 */
	function setObjectData($object){
		if(!isset($this->object_data)){
			$this->object_data = $object;
		}
	}

	/**
	 * @return AR
	 */
	function getObjectData(){
		return $this->object_data;
	}

	/**
	 * @param  $ActionList
	 */
	function setActionList($ActionList){
		if(!isset($this->object_data)){
			$this->ActionList = $ActionList;
		}
	}

	/**
	 * @return mixed
	 */
	function getActionList(){
		return $this->ActionList;
	}
	/**
	 * Создание объекта сущности
	 *
	 * Если предаваемые данные являются объектом, то этот объект берется за основу создоваемой сущности
	 * Если нет, то создаётся объект нужной сущности, которая указывается в $name_object
	 * Для дальнешего использования в системе
	 *
	 * @param $search_object - Название модели сущность которой нужно создать
	 * @param $id - Id сущности, которой нужно создать объект
	 * @param $object - объект сущности
	 *
	 * @return bool  если сущность создана то возвращается true, иначе false
	 * @throws \Exception
	 */
	function createObjectData($id){
		if(!isset($this->ActionList)){
			throw new \Exception('нет объекта ActionList');
		}
		$this->object_data  = $this->ActionList->object::find()->where(['id' => (int)$id])->one();

	}
	/**
	 * конструктор
	 *
	 * Создаюется переменная id пользователя, который запросил права
	 *
	 * @throws \Exception
	 */
	function __construct($objects = false)
	{
		if ($this->user_id == null) {
			if(!\Yii::$app->getRequest()->isConsoleRequest){
				$user = \Yii::$app->user->identity;
				$this->user_id = $user->id;
			}else{
				$this->user_id =1137;
			}

		}
	}

	/**
	 * @param bool $module
	 *
	 * @return AccessControl
	 * @throws \Exception
	 */
	public static function model($module=false) {
		$moduleAccess = \Yii::$app->getModule('access');

		if(isset($moduleAccess->modules[$module]['class'])){
			return  new $moduleAccess->modules[$module]['class']();
		}
		return  new AccessControl();
	}
	/**
	 * Проверка прав для группы
	 *
	 * Проверяет наличие прав н
	 *
	 * @param object $access - объект данных из строки в таблице jwu0a_access_data_action_link_group
	 * @param $data_action_id действие, которое запрашивается на проверку
	 *
	 * @return bool true или false
	 * @throws \Exception
	 */
	function check_feature($access = false, $data_action_id = false) {

		if ($access == false or $data_action_id == false) {

			return false;
		}
		if (isset($access->switch) and $access->switch == 1) {

			$rights = $access->rights; // получаем права
			$rights = explode(',', $rights);

			foreach ($rights as $right) {// проверяем входит пользователь в какую-либо категорию прав или нет
				$func = 'check_' . $right;
				$rights_user = $this->$func();
				if ($rights_user == true) { // если хоть одно разрешение есть, то возвращаем true
					return true;
				}
			}
		}
		return false;
	}

	function check_all(){
			return true;
	}


	/**
	 * Проверка прав на действие
	 *
	 * Функция проверяет наличие доступа к конкретному действию.
	 *
	 * @param string $action - строка с названием действия system_name в таблице jwu0a_access_action_list
	 *
	 * @return bool (true/false)
	 * @throws \Exception
	 */
	function check_action($action) {
		$settings =  AccessDataActionRepository::getActionLines($action);

		if (!$settings) {
			return false;
		}

		foreach ($settings as $value) {

			$condition_data = json_decode($value['condition_data']); //проверить массив или объект

			$CorrectData = (new AccessControlHelperServices())->DataComparison($condition_data,$this->object_data,false);



			if ($CorrectData) {
				$this->action = (object)($value);

				$group_info =AccessGroupRepository::getAccessForGroup($value);

				$access=false;
				if ($group_info) {// если есть права для группы
					foreach ($group_info as $info) {
						$name='checkGroup_'.$info['type_group'];
						$access = AccessGroupRepository::$name($info);
						if($access){
							break;
						}
					}
				}


				$rights = explode(',', $value['rights']);

				foreach ($rights as $right) {// проверяем входит пользователь в какую-либо категорию прав или нет

					if ($right) {

						$func = 'check_' . $right;
						$rights_user = $this->$func();

						if ($rights_user == true) { // если хоть одно разрешение есть, то возвращаем true

							if ($access) {// если пользователь состоит в группе, то возвращаем права группы

								$access_group = $this->check_feature($access, $value['id']);


								if ($access_group === true) {

									return $access_group;

								} else {
									continue;
								}
							}
							return true;

						} else {
							if ($access) {// если пользователь состоит в группе, то возвращаем права группы
								$access_group = $this->check_feature($access, $value['id']);
								if ($access_group === true) {
									return $access_group;
								} else {
									continue;
								}
							}
						}
					} else {
						if ($access) {// если пользователь состоит в группе, то возвращаем права группы
							$access_group = $this->check_feature($access, $value['id']);
							if ($access_group === true) {
								return $access_group;
							} else {
								continue;
							}
						}
					}
				}
			}
		}


		return false;
	}
	/**
	 * Получение данных - data из таблицы действий
	 *
	 * @param elem - действие
	 *
	 * @return data
	 * @throws \Exception
	 */
	function getDataAction(){
		if(isset($this->action->data)){
			return json_decode($this->action->data);
		}
		return false;
	}

	/**
	 * Получение и проверка прав кнопок // вынести в TASK
	 *
	 * Вызывается из common\widgets\AccessButtons
	 *
	 * @param $elem  - массив кнопок(действий) которые могут быть выполнены над задачей
	 * @param  $data - объект модели задачи
	 *
	 * @return html
	 * @throws \Exception
	 */
	function getHtml($module, $elem, $data = Array(),$dep_users = false) {

		foreach ($elem as $value) {
			$settings = $this->check_action($value);

			if ($settings) {
				$buttons[$value] = true;
			} else {
				$buttons[$value] = false;
			}
		}
		$moduleAccess = \Yii::$app->getModule('access');
		$class = new $moduleAccess->modules[$module]['buttons']($this->object_data);

		$class->getData();
		$html = '';

		foreach ($buttons as $name => $value) {
			if ($value === true) {
				$html.= $this->createButton($name, $class,$data,$dep_users);
			}
		}

		return $html;
	}
	/**
	 * Создание кнопки
	 *
	 * @param  $data - данные об кнопках
	 * @param  $name - Название кнопки(действия)
	 * @param  $task -  объект модели задачи
	 * @param  $dep_users -  не понятно для чего
	 *
	 * @return html
	 * @throws \Exception
	 */
	function createButton($name,$data,$task,$dep_users) {

		$html_button = '';
		if (method_exists($data,'html'.$name)){
			$html='html'.$name;
			return $data->$html($task,$dep_users,$this);
		}
		$data= $data->data;
		if (!isset($data[$name])) {
			$name_button = $this->ActionList->system_name;
			$html_button.= '<li class="li-btn"><a class="btn btn-white" href="index.php?r=access/default/action&action=' . $name . '&data[id]=' . $this->object_data['id'] . '"> ' . $name_button . ' </a></li>&nbsp';
		} else {
			$html_button.= '<li class="li-btn"><a   class="btn-white ' . $data[$name]["class"] . '" href="' . $data[$name]["href"] . '"> ' . $data[$name]["icon"] . ' </a></li>&nbsp';
		}

		return $html_button;
	}



//    Action model   ****************************************************************************************




	/**
	 * Выполнение действий
	 *
	 * Выполняется когда у пользователя есть права на действие.
	 * Переберается объект EditDataObject полученный из колонки action->action_button  в таблице jwu0a_access_data_action
	 *
	 *
	 * @param $property объект с действиями jwu0a_access_data_action из бд
	 *
	 * @return null ничего не возвращает
	 * @throws \Exception
	 */
	function ActionObject()
	{
		$apply = new $this->applyObjectServices();

		$apply->conditions($this);
		$apply->Apply($this);
		(new $this->NotificationServices())->sendNotification($this);
		(new $this->CustomFunctionServices())->checkAndApply($this);
		return true;
	}

}
