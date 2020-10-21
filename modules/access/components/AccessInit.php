<?php
namespace frontend\modules\access\components;

use Yii;
use yii\helpers\Url;

class AccessInit  extends \yii\base\ BaseObject  {

	public function init()
	{



		$login = 0;
		// запоминаем страницу неавторизованного пользователя, чтобы потом отредиректить его обратно с помощью  goBack()
		if (Yii::$app->getUser()->isGuest) {
			$request = Yii::$app->getRequest();
			// исключаем страницу авторизации или ajax-запросы
			if (!($request->getIsAjax() || strpos($request->getUrl(), 'login') !== false
			      ||  Yii::$app->request->get('r') !== ''
			      ||  Yii::$app->request->get('r') !== 'user/recovery/request'
			      ||  Yii::$app->request->get('r') !== 'user/recovery/reset')) {
				Yii::$app->getUser()->setReturnUrl($request->getUrl());
			}
		}

		if (Yii::$app->getUser()->isGuest &&
		    (Yii::$app->getRequest()->url !== Url::to(Yii::$app->getUser()->loginUrl)
		     && Yii::$app->request->get('r') !== 'user/recovery/request'
		     && Yii::$app->request->get('r') !== 'user/recovery/reset'
		     && Yii::$app->request->get('r') !== 'task/task/robot24'
		     && Yii::$app->request->get('r') !== 'task/task/robot1'
		     && Yii::$app->request->get('r') !== 'api/add-appeal'
		     && Yii::$app->request->get('r') !== 'api/taskcreate'
		     && Yii::$app->request->get('r') !== 'api/task-action'
		     && Yii::$app->request->get('r') !== 'api/send-pulse'
		     && Yii::$app->request->get('r') !== 'task/sprints/backlog/get-backlog'
		    )
		) {
			Yii::$app->getResponse()->redirect(Yii::$app->getUser()->loginUrl)->send();
		} elseif(Yii::$app->getUser()->isGuest) {
			$login = 1;
		}

		parent::init();

	}

}
