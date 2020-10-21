<?php

namespace frontend\modules\crm\modules\appeal\factories;

use frontend\modules\crm\modules\appeal\references\AnswerReferences;
use yii\base\Model;
use frontend\modules\notification\helpers\NotificationHelper;
use \frontend\modules\crm\modules\appeal\models\base\AppealAnswer;

class DistributionAnswerFactories extends Model
{


	function startDistribution(){

		$appealAnswers=AppealAnswer::find()->where('id_author IS NOT NULL AND date_sending IS NULL')->all();

		foreach ($appealAnswers as $appealAnswer) {
			if($appealAnswer->chanel==null){
				NotificationHelper::sendSlack('Ошибка при отправке ответа на обращение: нет канала. ');
			}
			(new AnswerReferences::$serviceChanelObj[$appealAnswer->chanel]($appealAnswer))->sendAnswer();
		}
		self::startCheckRead();

	}

	function startCheckRead(){
		$time=time()-86000*3;
		$appealAnswers=AppealAnswer::find()->where('
        read_email=0 AND read_sms=0 AND
        id_author IS NOT NULL AND
        date_sending IS NOT NULL AND 
        date_sending>'.$time)->all(); //  AND date_sending IS NOT NULL

		foreach ($appealAnswers as $appealAnswer) {
			(new AnswerReferences::$serviceChanelObj[$appealAnswer->chanel]($appealAnswer))->checkRead();
		}
	}
}