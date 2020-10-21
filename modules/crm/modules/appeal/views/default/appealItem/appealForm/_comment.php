<?php

use yii\widgets\ActiveForm;
use yii\helpers\Html;
use yii\helpers\Url;

?>
    <p>Комментарий не отправляется клиенту, он нужен для заметок по обращению</p>

<?php

$form = ActiveForm::begin(
	[
		'id'          => 'form_comment',
		'action'      => [ '/crm/appeal/default/add-answer' ],
		'fieldConfig' => [
			'template'     => ' <div class="form-group form-group-invisible">{label} <div class="col-sm-offset-2 col-sm-9 ">{input}</div></div>',
			'labelOptions' => [ 'class' => 'control-label-invisible', 'for' => 'inputDisabled' ],

		],
		'options'     => [
			'class'     => 'form-horizontal ',
			'data-name' => 'form_comment',
			'data-pjax' => true,
		]
	] ); ?>

<?= $form->field( $modelAnswer, 'id_appeal' )->label( '' )->hiddenInput(); ?>
<?= $form->field( $modelAnswer, 'chanel' )->label( '' )->hiddenInput( [ 'value' => 5 ] ); ?>

<?= $form->field( $modelAnswer, 'text' )->label( 'Комментарий:' )->textarea( [ 'rows' => 6 ] ) ?>

    <div class="col-sm-offset-2">
		<?= Html::Button( 'Оставить комментарий', [ 'class'     => 'btn btn-success',
		                                            'id'        => 'send-answer',
		                                            'data-form' => 'form_comment',
		                                            'data-url'  => Url::to( [ '/crm/appeal/default/add-answer' ] )
		] ); ?>
    </div>

<?php ActiveForm::end(); ?>