<?php

namespace frontend\modules\crm\modules\appeal\repository;

use frontend\modules\crm\modules\appeal\models\AppealItems;
use frontend\modules\crm\modules\appeal\models\base\AppealAnswer;
use frontend\modules\notification\services\SendNotificationService;
use yii\db\Query;

class AppealItemRepository
{

	public static function getAppealItem($id)
	{
		return (new Query())
			->from(AppealItems::tableName())
			->select([AppealItems::tableName() . '.*'])
			->where([AppealItems::tableName() . '.id' => $id])
			->scalar();
	}

	/**
	 * @param AppealItems $entity
	 * @return array|bool
	 */
	public static function createAppealIntem(AppealItems $entity){
		if ($entity->save()) {
			return $entity->getErrors();
		} else {
			return false;
		}
	}


	public static function autoCloseAppealItem(){
		$subquery = AppealAnswer::find()
		                        ->select('date_sending')
		                        ->where(AppealItems::tableName().'.id = '.AppealAnswer::tableName().'.id_appeal')
		                        ->orderBy(AppealAnswer::tableName().'.date_sending DESC')
		                        ->limit(1)->createCommand()->getRawSql();

		$appeals = AppealItems::find()
		                      ->select(AppealItems::tableName().'.*')
		                      ->addSelect(['last_active' => '('.$subquery.')',])
		                      ->where( AppealItems::tableName() .'.status=2')
		                      ->all();

		$time=86400*4;
		if(isset($appeals)) {
			foreach ($appeals as $appeal) {
				if((time()-$appeal->last_active)>$time){
					$close[]=$appeal->id;
					$appeal->status=3;
					$appeal->save();
				}
			}
			if (isset($value)) {
				$model = new \stdClass();
				$model->close = implode(",", $close);
				(new SendNotificationService())->sendOneNotificationToUser('autoCloseAppealReport', 1348, $model);
			}
			return true;
		}
		return false;
	}

}