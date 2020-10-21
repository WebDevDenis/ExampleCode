<?php
/**
 * Class EmailLetterPickerServices
 */
namespace frontend\modules\crm\modules\appeal\services\letterPickers;

use frontend\modules\access\components\CAccessAction;
use frontend\modules\crm\modules\appeal\models\AppealItems;
use frontend\modules\crm\modules\appeal\models\base\AppealAnswer;
use frontend\modules\crm\modules\appeal\repository\AppealItemRepository;
use frontend\modules\crm\modules\appeal\repository\AppealAnswerRepository;
use frontend\modules\crm\modules\appeal\references\AnswerReferences;
use frontend\modules\crm\modules\appeal\references\ItemsReferences;
use frontend\modules\notification\services\SendNotificationService;
use frontend\modules\notification\helpers\NotificationHelper;

class EmailLetterPickerServices
{
	private $storage;
	static function getListEmails(){
		return \Yii::$app->getModule('crm')->getModule('appeal')->params['letterPicker']['emails'];
	}

	static function greactConecting($configAccount){

		$model=get_called_class();
		$model=new $model;

		$model->storage = new \PhpImap\Mailbox(
			$configAccount['host'], // IMAP server and mailbox folder
			$configAccount['user'], // Username for the before configured mailbox
			$configAccount['password'] // Password for the before configured username
//            __DIR__, // Directory, where attachments will be saved (optional)
//            'UTF-8' // Server encoding (optional)
		);


		return $model;
	}

	public function startPickers() {

		try {
			$mailsIds = $this->storage->searchMailbox('UNSEEN');
		} catch(PhpImap\Exceptions\ConnectionException $ex) {
			echo "IMAP connection failed: " . $ex; //@TODO allert admin
			die();
		}

		if(!$mailsIds) {
			return false;
		}



		foreach ($mailsIds AS $mailId) {
			if ($this->parseMsg($mailId)) {
				$this->storage->markMailAsRead($mailId);
			}
		}

	}

	protected function parseMsg(int $id)
	{
		$mail=$this->storage->getMail($id);

		$appeal_id = $this->checkTikets($mail->subject);

		if(empty($mail->textPlain)){
			$text= $mail->textHtml;
		}else{
			$text= $mail->textPlain;
		}

		if ($appeal_id) {
			$message=$text;
			preg_match('/data-answer/', $message, $fl_array);

			if ($fl_array) {
				$message = explode('-- пожалуйста отвечайте выше этой линии --', $message)[0];
			}
			preg_match('/Служба поддержки Сеть-техники/', $message, $fl_array_st);
			if ($fl_array_st) {
				$message = explode( 'Служба поддержки Сеть-техники', $message )[0];
			}

		} else {
			$message=$mail->textPlain;
		}

		if ( $appeal_id && AppealItemRepository::getAppealItem( $appeal_id ) ) {
			$appealAnswer               = new AppealAnswer();
			$appealAnswer->text         = $message;
			$appealAnswer->id_appeal    = $appeal_id;
			$appealAnswer->chanel       = AnswerReferences::CHANEL_EMAIL;
			$appealAnswer->date_created = time();

			$access =(new CAccessAction())->applyAction("CreatingAppealAnswer",$appealAnswer);

			if ($errors = AppealAnswerRepository::createAppealAnswer( $appealAnswer  )  || !$access ) {
				NotificationHelper::sendSlack(json_encode('Проблема с правами при создании ответа на обращение или ошибка: '.$errors));
			}
		} else {
			$appealItems        = new AppealItems();
			$appealItems->text  = $message;
			$appealItems->title = \Yii::$app->getModule( 'crm' )->getModule( 'CreatingAppeal' )->params['templateTheneNewEmail'] . $mail->subject;

			$appealItems->channel      = ItemsReferences::CHANEL_MANUAL;
			$appealItems->category     = ItemsReferences::CATEGORY_OVER;
			$appealItems->status       = 1;
			$appealItems->created_date = time();
			$appealItems->email        = $mail->fromAddress;

			$access =(new CAccessAction())->applyAction("CreatingAppeal",$appealItems);

			if ($errors = AppealItemRepository::createAppealIntem( $appealItems ) || !$access) {
				NotificationHelper::sendSlack(json_encode('Проблема с правами при создании обращения или ошибка: '.$errors));
			}
		}
	}

	protected function checkTikets(string $str){
		preg_match('/\['.\Yii::$app->getModule('crm')->getModule('appeal')->params['templateEmailSubject'].'(.*)\]/', $str, $fl_array);

		if (!$fl_array) {
			return false;
		}

		if (is_numeric($fl_array[1])) {
			return (int)$fl_array[1];
		}

		return false;
	}
}
