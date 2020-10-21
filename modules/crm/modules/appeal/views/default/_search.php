<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model frontend\modules\crm\modules\appeal\models\search\SearchAppealItems */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="appeal-items-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'channel') ?>

    <?= $form->field($model, 'category') ?>

    <?= $form->field($model, 'text') ?>

    <?= $form->field($model, 'title') ?>


    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-outline-secondary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
