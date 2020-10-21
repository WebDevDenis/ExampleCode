<?php
use frontend\modules\crm\modules\appeal\references\AnswerReferences;
use frontend\modules\sms\references\SmsLogsReferences;
foreach ($model->answers as $answer) {
	$style='';
	switch ($answer->chanel) {
		case 4:
			$style="border-right: 4px solid #217822;";
			break;
		case 5:
			$style="border-right: 4px solid #0e1013;";
			break;
		case 6:
			$style="border-right: 4px solid #ff0000;";
			break;
	}

	if ($answer->chanel == 3 || $answer->chanel == 4  ){
		if($answer->chanel == 4){
			$word='Статус:';
		}else{
			$word='Прочтено:';
		}
		$status='-';
		if($answer->chanel == 3 && $answer->read_email==1){
			$status='Да';
		}else{
			$status='Нет';
		}
		if($answer->chanel == 4 && $answer->status_sms!=0){
			$status=SmsLogsReferences::$statusesGateway[$answer->status_sms];
		}
		$date_send='<p><b>Дата отправки:</b> '.(($answer->date_sending!=null)? date('d.m.Y  H:i',$answer->date_sending): "Отправляется...").'</p>
	<p><b>'.$word.'</b> '.$status.'</p>';
	}else{
		$date_send='';
	}


	if($answer->id_author !=null){
		echo '<div class="from-me text-answer d-flex">
		<div class="d-flex flex-column border-right-answer block-info-answer" style="    min-width: 255px;
    max-width: 255px; '.$style.'">
		<p><b>Автор:</b> <br>'.$answer->author->fullName.'</p>
		<p><b>Тип ответа:</b> <br>'.AnswerReferences::$serviceChanelRenderName[$answer->chanel].'</p>
		'.$date_send.' 
		

		
		</div>
		<div class="block-text-answer">
		' .$answer->text."
		</div>
		</div>";
	}else{
		echo '<div class="from-them text-answer d-flex">
		<div class="d-flex flex-column border-right-answer block-info-answer" style="min-width: 255px;
    max-width: 255px; '.$style.' ">
		<p><b>Клиент</b></p>
		<p><b>Дата получения:</b>'.date('d.m.Y  H:i',$answer->date_created).'</p>
		</div>
		<div class="block-text-answer">
		' .$answer->text."
		</div>
		</div>";
	}
}
?>
