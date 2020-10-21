<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model frontend\modules\crm\modules\appeal\models\AppealItems */

$this->title = 'Создать обращение';
$this->params['breadcrumbs'][] = ['label' => 'Обращения клиентов', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>


    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

