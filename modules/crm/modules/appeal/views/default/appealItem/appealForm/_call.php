<?php

use yii\widgets\ActiveForm;
use yii\helpers\Html;
use yii\helpers\Url;
?>
    <p>В будущем будет доработано, пока не работает, но можно оставлять комментарий о результате звонка </p>
    <button id="answer-call" class="btn btn-primary" data-id="<?php echo $modelAnswer->id_appeal?>" data-url="<?php echo Url::to( [ "/crm/appeal/default/add-call"])?>"> Позвонить</button>
<?php
$form = ActiveForm::begin(
	[
		'id'          => 'form_call',
		'action'      => [ '/crm/appeal/default/add-answer' ],
		'fieldConfig' => [
			'template'     => ' <div class="form-group form-group-invisible">{label} <div class="col-sm-offset-2 col-sm-9 ">{input}</div></div>',
			'labelOptions' => [ 'class' => 'control-label-invisible', 'for' => 'inputDisabled' ],

		],
		'options'     => [
			'class'     => 'form-horizontal ',
			'data-name' => 'form_call',
			'data-pjax' => true,
		]
	] ); ?>

<?= $form->field( $modelAnswer, 'id_appeal' )->label( '' )->hiddenInput(); ?>
<?= $form->field( $modelAnswer, 'chanel' )->label( '' )->hiddenInput( [ 'value' => 6 ] ); ?>

<?= $form->field( $modelAnswer, 'text' )->label( 'Результат звонка:' )->textarea( [ 'rows' => 6 ] ) ?>
    <div class="col-sm-offset-2">
		<?= Html::Button( 'Комментарий к звонку звонка', [ 'class'     => 'btn btn-success',
		                                                   'id'        => 'send-answer',
		                                                   'data-form' => 'form_call',
		                                                   'data-url'  => Url::to( [ '/crm/appeal/default/add-answer' ] )
		] ); ?>
    </div>

<?php ActiveForm::end(); ?>