<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model frontend\modules\crm\models\CrmClients */

$this->title = 'Создание клиента';
$this->params['breadcrumbs'][] = ['label' => 'Клиенты', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>



    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>
