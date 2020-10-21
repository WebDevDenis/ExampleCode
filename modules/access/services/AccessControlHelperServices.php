<?php


namespace frontend\modules\access\services;

use frontend\modules\notification\services\SendNotificationService;

class AccessControlHelperServices {

	public static function	functionCheck ($str){
		if(is_string($str) && strripos($str, '(')){
			return true;
		}
		return false;
	}

	public static  function	getFunctionParam ($str){
		return substr(substr("$str", strripos($str,'('), strripos($str,')')), 1, -1);
	}
	public static  function	getNameFunction ($str){
		return substr("$str",0,  strripos($str,'('));
	}

	public function DataComparison ($condition_data,$object_data,$accessObject=false){
		$flag = true;
		$e=false;
		if ($condition_data !== null) {

			foreach ($condition_data as $property => $property_value) {
				$props = explode('_', $property,2);

				if (isset($object_data->module) and $object_data->module == $props[0]) {// разделяем task и статус и сравниваем task с task в объекте
					$e=$props[1];

					if (self::functionCheck($property_value->value)){
						$nameFunction =self::getNameFunction($property_value->value);
						$paramsFunction = self::getFunctionParam($property_value->value);
						$AfterApply = $accessObject->getAfterApplyObjectServices();

						$flag= (new $AfterApply())->{$nameFunction}($accessObject,$paramsFunction);
						if(!$flag){break;}

					}elseif (strripos($props[1], '.')) {// проверка на строку #'userCreated.departments.departmentGroupsLinks.group_id';

						$data = explode('.', $props[1]);

						$proper = $this->getRelations($object_data,$data);
						if (!$this->verify_data($object_data,$property_value, $proper,true)) {// проверяем data, чтоб всё совпало

							$flag = false;
							break;
						}
					} else {

						if (!$this->verify_data($object_data,$property_value, $props[1])) {// проверяем data, чтоб всё совпало

							$flag = false;
							break;
						}
					}
				}else{
					$flag = false;
				}
			}
		}

		return $flag;
	}

	/**
	 * Получение данных через связь
	 *
	 * Заранее строка запроса связей - userCreated.departments.departmentGroupsLinks.group_id
	 * и затем перебирается рекурсивны методом для получения нужных данных из связанных таблиц
	 *
	 * @param object $object - модель у которой проверяются права доступа
	 * @param array $data - массив связей
	 *
	 * @return false or object
	 * @throws \Exception
	 */
	function getRelations($object,$data) {

		if(isset($object->{$data[0]})){
			$object = $object->{$data[0]};
		}else{
			return false;
		}
		array_shift($data);
		if(isset($data[0])){
			return $this->getRelations($object,$data);
		}
		return $object;
	}


	/**
	 * Проверка условий
	 *
	 * Данные из колонки condition_data сопоставляются с объектом модели
	 * При полном совпадении возвращается true и проверка прав продолжается
	 *
	 * @param property_value - данные из колонки condition_data
	 * @param array $property - объект модели
	 * @param bool $flag - флаг совпадения
	 *
	 * @return false or object
	 * @throws \Exception
	 */
	function verify_data($object_data,$property_value, $property, $flag = false) {

		if ($flag) {
			$data = $property;

		} else {
			if(isset($object_data->{$property})){
				$data = $object_data->{$property};

			}else{
				return false;
			}

		}

		if (!isset($property_value->operator)) {
			return false;
		}
		if ($property_value->operator == '=') {
			foreach ($property_value->value as $val) {

				if ($data != $val ) {
					$flag = false;
				} else {

					$flag = true;
					break;
				}
			}
		}

		if ($property_value->operator == '!=') {
			foreach ($property_value->value as $val) {
				if ( $data == $val ) {
					$flag = false;
					break;
				}else {
					$flag = true;
				}
			}
		}

		if ($property_value->operator == '>') {
			foreach ($property_value->value as $val) {
				if ($data > $val) {
					$flag = false;
				} else {
					$flag = true;
					break;
				}
			}
		}

		if ($property_value->operator == '<') {
			foreach ($property_value->value as $val) {
				if ($data < $val ) {
					$flag = false;
				} else {
					$flag = true;
					break;
				}
			}
		}
		if ($property_value->operator == '>=') {
			foreach ($property_value->value as $val) {

				if ($data >= $val ) {
					$flag = false;
				} else {
					$flag = true;
					break;
				}
			}
		}
		if ($property_value->operator == '<=') {
			foreach ($property_value->value as $val) {
				if ( $data <= $val ) {
					$flag = false;
				} else {
					$flag = true;
					break;
				}
			}
		}
		if(empty($flag)){
			$flag=false;
		}

		return $flag;
	}


}