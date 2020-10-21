<?php


namespace frontend\modules\access\repository;

use yii\db\Query;
use  frontend\modules\org\repository\OrgUsers;

class AccessGroupRepository
{
	public static function getUserGroup($group) {
		$groupList = self::getGroup(['name'=>$group]);
		if($groupList['type']=="users"){
			return self::getGroupLinksData($groupList['id'],'data as user_id');
		}elseif($groupList['type']=="post"){
			foreach ( self::getGroupLinksData($groupList['id'],'data') as $item){
				$postLinks[]	= $item['data'];
			}
			return OrgUsers::getPostInDepartmentUsers($postLinks);
		}
		return false;
	}

	public static function getGroup(array $where) {
		return (new Query())
			->from('jwu0a_access_group_list')
			->where($where)
			->one();
	}
	public static function getGroupLinksData($id,$select='*') {
		return (new Query())
			->select($select)
			->from('jwu0a_access_group_link ')
			->where(['group_id' => $id])
			->all();
	}

	public static function getAccessForGroup($value) {
		return  (new \yii\db\Query())
			->select('acgr.*,gr.type AS type_group,gl.data AS group_data')
			->from('jwu0a_access_data_action_link_group acgr')
			->leftJoin('jwu0a_access_group_list gr ON (acgr.group_id= gr.id )')
			->leftJoin('jwu0a_access_group_link gl ON (acgr.group_id= gl.group_id )')
			->where(['acgr.data_action_id' => $value['id']])
			->all();
	}

	public static  function  checkGroup_chief($info) {
		if ($info['type_group'] == 'chief') {
			$chiefs = (new \yii\db\Query())
				->select('chief')
				->from('jwu0a_sd_department')
				->all();

			foreach ($chiefs as $chief) {
				if ($chief['chief'] == \Yii::$app->user->identity->id) {
					return (object)$info;
				}
			}
			return false;
		}
	}

	public static function checkGroup_post($info) {
		if ($info['type_group'] == 'post') {
			$group = (new \yii\db\Query())
				->select('pu.user_id')
				->from('dkw2t_org_post_link_department pld')
				->leftJoin('dkw2t_posts_users pu ON (pu.post_link_id = pld.post_link_id )')
				->where('pld.post_id="' . $info['group_data'] . '" ')
				->all();
			foreach ($group as $post) {
				if ((int)$post['user_id'] === \Yii::$app->user->identity->id) {
					return (object)$info;
				}
			}
			return false;
		}
	}

	public static function checkGroup_users($info) {
		if ($info['type_group'] == 'users') {
			$group = (new \yii\db\Query())
				->from('jwu0a_access_group_link')
				->where('group_id="' . $info['group_id'] . '" AND  data="' . \Yii::$app->user->identity->id . '" ')
				->one();
			if ($group) {
				if ($group['group_id'] == $info['group_id']) {
					return (object)$info;
				}
			}
			return false;
		}
	}



}