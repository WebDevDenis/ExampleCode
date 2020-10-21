<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model frontend\modules\crm\models\CrmClients */
/* @var $form yii\widgets\ActiveForm */
$script = <<< JS


function addClient() {
    // console.log($("#name_client").lenght>0);
      if($("#name_client").length>0 ) {
        $.ajax({
                url:     '/index.php?r=crm%2Fclient%2Fajax-create',
                type:     "get", 
                dataType: "json", 
                data: $("#client-form").serialize(), 
                success: function(response) { 
                    var data = $.map(response, function (val) {
                      return val;
                    });
                    $("#select-client").select2({
                      data: (data)
                    })
                    ModalBase.ModalClose();
                    $("body").removeClass('modal-open');
                },
                error: function(response) { // Данные не отправлены
                    $('#info-form').html('Ошибка. Данные не отправлены.');
                }
            });
        }
      return false;
  
    }
       
JS;
//маркер конца строки, обязательно сразу, без пробелов и табуляции
$this->registerJs($script, yii\web\View::POS_LOAD);
?>

<div class="crm-clients-form" style="padding: 40px">
    <div id="info-form" >
    </div>
    <h1><?= Html::encode($this->title) ?></h1>

    <?php $form = ActiveForm::begin(['id' => 'client-form',]); ?>

    <?= $form->field($model, 'name')->label('Имя (обязательно)')->textInput(['id'=>'name_client']) ?>

    <?= $form->field($model, 'surname')->label('Фамилия')->textInput() ?>

    <?= $form->field($model, 'patronymic')->label('Отчество')->textInput() ?>


    <?= $form->field($model, 'type')->label('Тип клиента')->dropDownList($model->getAllType()) ?>

    <div class="form-group">
        <a href="javascript:void(0);" onclick="addClient();" class="btn btn-success ">Создать</a>

    </div>

    <?php ActiveForm::end(); ?>

</div>
