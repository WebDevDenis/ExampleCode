<?php


namespace frontend\modules\access\repository;

use yii\db\Query;

class AccessDataActionRepository
{
	public static function getActionLines($action) {
		return (object)(new Query())
		->select('da.*, al.system_name AS action_name')
		->from('jwu0a_access_data_action da')
		->leftJoin('jwu0a_access_action_list al ON (al.id = da.action_id)')
		->where(['al.system_name' => $action])
		->all();
	}
}