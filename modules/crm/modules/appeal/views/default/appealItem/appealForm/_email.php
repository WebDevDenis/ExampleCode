<?php

use yii\widgets\ActiveForm;
use yii\helpers\Html;
use yii\helpers\Url;

?>
    <p>Будет отправлен ответ клиенту по email</p>
<?php
$form = ActiveForm::begin(
	[
		'id'          => 'form_email',
		'action'      => [ '/crm/appeal/default/add-answer' ],
		'fieldConfig' => [
			'template'     => ' <div class="form-group form-group-invisible">{label} <div class="col-sm-offset-2 col-sm-9 ">{input}</div></div>',
			'labelOptions' => [ 'class' => 'control-label-invisible', 'for' => 'inputDisabled' ],

		],
		'options'     => [
			'class'     => 'form-horizontal ',
			'data-name' => 'form_email',
			'data-pjax' => true,
		]
	] ); ?>

<?= $form->field( $modelAnswer, 'id_appeal' )->label( '' )->hiddenInput(); ?>
<?= $form->field( $modelAnswer, 'chanel' )->label( '' )->hiddenInput( [ 'value' => 3 ] ); ?>

<?= $form->field( $modelAnswer, 'text' )->label( 'Тескт ответа:' )->textarea( [ 'rows' => 6 ] ) ?>
    <div class="col-sm-offset-2">
		<?= Html::Button( 'Отправить', [ 'class'     => 'btn btn-success',
		                                 'id'        => 'send-answer',
		                                 'data-form' => 'form_email',
		                                 'data-url'  => Url::to( [ '/crm/appeal/default/add-answer' ] )
		] ); ?>
    </div>

<?php ActiveForm::end(); ?>