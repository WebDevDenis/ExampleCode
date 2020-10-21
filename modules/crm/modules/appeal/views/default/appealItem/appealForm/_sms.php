<?php

use yii\widgets\ActiveForm;
use yii\helpers\Html;
use yii\helpers\Url;

$script = <<< JS
(function($){}(jQuery));


//Start
$(function(){
    

})
JS;
//маркер конца строки, обязательно сразу, без пробелов и табуляции
$this->registerJs($script, yii\web\View::POS_LOAD);
?>
    <p>Будет отправлен ответ клиенту через sms</p>



<?php
$form = ActiveForm::begin(
	[
		'id'          => 'form_sms',
		'action'      => [ '/crm/appeal/default/add-answer' ],
		'fieldConfig' => [
			'template'     => ' <div class="form-group form-group-invisible">{label} <div class="col-sm-offset-2 col-sm-9 ">{input}</div></div>',
			'labelOptions' => [ 'class' => 'control-label-invisible', 'for' => 'inputDisabled' ],

		],
		'options'     => [
			'class'     => 'form-horizontal ',
			'data-name' => 'form_sms',
			'data-pjax' => true,
		]
	] ); ?>

<?= $form->field( $modelAnswer, 'id_appeal' )->label( '' )->hiddenInput(); ?>
<?= $form->field( $modelAnswer, 'chanel' )->label( '' )->hiddenInput( [ 'value' => 4 ] ); ?>

<?= $form->field( $modelAnswer, 'text' )->label( 'Тескт смс:' )->textarea( [ 'rows'      => 6,
                                                                             'data-name' => 'sms-message',
                                                                             'id'=>'sms-message',
                                                                             'maxlength' => 350
] ) ?>
    <div id="hint-block" class="hint-block text-warning col-sm-offset-2">Максимум 350 символов</div>
    <div class="col-sm-offset-2">
		<?= Html::Button( 'Отправить', [ 'class'     => 'btn btn-success',
		                                 'id'        => 'send-answer',
		                                 'data-form' => 'form_sms',
		                                 'data-url'  => Url::to( [ '/crm/appeal/default/add-answer' ] )
		] ); ?>
    </div>

<?php ActiveForm::end(); ?>