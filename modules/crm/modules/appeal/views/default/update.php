<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model frontend\modules\crm\modules\appeal\models\AppealItems */

$this->title = 'Update Appeal Items: ' . $model->title;
$this->params['breadcrumbs'][] = ['label' => 'Appeal Items', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->title, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="appeal-items-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
