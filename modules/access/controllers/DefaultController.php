<?php

namespace frontend\modules\access\controllers;

use frontend\controllers\FrontendController;
use yii\helpers\Url;
use frontend\modules\access\components\CAccessAction;

use  frontend\modules\access\models\ActionList;
/**
 * Default controller for the `Access` module
 */
class DefaultController extends FrontendController {



	function actionAction() {
		$updateData = \Yii::$app->getRequest()->getQueryParam('data');
        $action = \Yii::$app->getRequest()->getQueryParam('action');

		$model_access=new CAccessAction();
		$model_access->baseAccess($action);
		$post=\Yii::$app->request->post();
		$post= array_change_key_case($post, CASE_LOWER);

		if(isset($post[$model_access->accessObject->getActionList()->module]) && $post[$model_access->accessObject->getActionList()->module]!=null) {
			$updateData = array_merge($updateData, $post[$model_access->accessObject->getActionList()->module]);
		}

		$access = $model_access->applyAction($action,false,$updateData['id'],$updateData);
		if (!$access) {
			\Yii::$app->session->setFlash('error', 'Нет прав');
		} else {
			\Yii::$app->session->setFlash('success', 'Успешно');
		}
		if(!method_exists($model_access->accessObject->object_data,'getUrl')){
			throw new \Exception('В сущности нет getUrl()');
		}
        return \Yii::$app->response->redirect($model_access->accessObject->object_data->getUrl($updateData['id']))->send();
    }


}
