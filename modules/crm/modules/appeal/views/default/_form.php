<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model frontend\modules\crm\modules\appeal\models\AppealItems */
/* @var $form yii\widgets\ActiveForm */
//
$script = <<< JS
$('#responsible-user').on("select2:select", function(e) { 
    if(e.params.data.id!=''){
        $('#responsible-department').prop('disabled', true);
    }else{
         $('#responsible-department').prop('disabled', false);
    }
});
$('#responsible-department').on("select2:select", function(e) { 
    if(e.params.data.id!=''){
        $('#responsible-user').prop('disabled', true);
    }else{
         $('#responsible-user').prop('disabled', false);
    }
});
$(".clients_search").select2({
    minimumInputLength: 2,
     allowClear: true,
   placeholder: "Поиск по клиентам",
    ajax: {
        url: 'index.php?r=crm/client/search-client',
        dataType: 'json',
        type: "GET",
        quietMillis: 50,
   
        data: function (term) {
            return {
                term: term
            };
        },
     processResults: function (data) {
      return {
        results: data.items
      };
    }
           
    }
});

      


JS;
//маркер конца строки, обязательно сразу, без пробелов и табуляции
$this->registerJs($script, yii\web\View::POS_LOAD);
?>


<section class="content-with-menu content-with-menu-has-toolbar mailbox">
    <div class="content-with-menu-container" data-mailbox-view="compose">
        <div class="inner-menu-toggle">
            <a href="#" class="inner-menu-expand" data-open="inner-menu">
                Show Menu <i class="fa fa-chevron-right"></i>
            </a>
        </div>

        <menu id="content-menu" class="inner-menu" role="menu" style="display: block !important;">
            <div class="nano">
                <div class="nano-content">

                    <div class="inner-menu-content">
                        <a href="/index.php?r=crm%2Fappeal" class="btn btn-block btn-primary btn-md pt-sm pb-sm text-md">
                            <i class="fa fa-envelope mr-xs"></i>
                            Все обращения
                        </a>

                    </div>
                </div>
            </div>
        </menu>
        <div class="inner-body">
            <div class="inner-toolbar clearfix">
                <ul>
                    <li>
                        <a href="#" id="filters" class="filters-close hidden-xs"><i class="fa  fa-search"></i> Меню</a>
                    </li>
                </ul>
            </div>
            <div class="mailbox-compose" style="padding: 40px; margin-top: -80px">

	                <?php $form = ActiveForm::begin(
		                [
			                'fieldConfig' => [
				                'template' => ' <div class="form-group form-group-invisible">{label} <div class="col-sm-offset-3 col-sm-8 col-md-offset-3 col-md-9">{input}</div></div>',
				                'labelOptions' => ['class' => 'control-label-invisible', 'for'=>'inputDisabled'],

			                ],
			                'options' => [
			                        'class'=>'form-horizontal form-bordered form-bordered',
				                'data-pjax' => true,
			                ]
		                ]); ?>


	            <?= $form->field($model, 'title')->label('Тема обращения')->textInput(['maxlength' => true]) ?>
	            <?= $form->field($model, 'category')->label('Категория обращения')->dropDownList($model->getSelectCategory(),['prompt' => 'Выберите категорию',]) ?>


	                <?= $form->field($model, 'text')->label('Тескт обращения')->textarea(['rows' => 6]) ?>





	                <?= $form->field($model, 'client_id',['template' => '<div class="form-group form-group-invisible">{label} <div class="col-sm-offset-3 col-sm-4 col-md-offset-3 col-md-5" style="margin-top: 9px;">{input}</div><div class="col-sm-2"><a href="#" class="modalStart mb-xs mt-xs mr-xs btn btn-success"  data-modalrequest="index.php?r=crm%2Fclient%2Fcreate&modal=1" >Создать клиента</a></div> </div><div></div>'])->label('Клиент')->dropDownList([],['id'=>'select-client','data-plugin-selectTwo'=>'','class'=>'form-control populate clients_search' ,'prompt'=>'Начните искать клиента или создайте нового' ]); ?>


	                <?= $form->field($model, 'email')->label('Почта')->textInput(['maxlength' => true]) ?>

	                <?= $form->field($model, 'phone')->label('Телефон')->textInput() ?>



	                <?= $form->field($model, 'user_id')->label('Ответственный сотрудник')->dropDownList($model->getAllDepUsers(),['id'=>'responsible-user','prompt' => 'Выберите сотрудника','data-plugin-selectTwo'=>'','class'=>'form-control populate placeholder-responsible-user','placeholder'=>'1' ]) ?>

	                <?= $form->field($model, 'department_id')->label('Ответственный отдел')->dropDownList($model->getDepartment(),['id'=>'responsible-department','prompt' => 'Выберите отдел',]) ?>

                    <div class="form-group">
		                <?= Html::submitButton('Сохранить', ['class' => 'btn btn-success']) ?>
                    </div>

	                <?php ActiveForm::end(); ?>




            </div>
        </div>
    </div>
</section>
<!-- end: page -->
</section>



