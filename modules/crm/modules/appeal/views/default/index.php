<?php


use yii\widgets\ActiveForm;
use yii\widgets\Pjax;

$this->title = 'Обращения клиентов';
$this->params['breadcrumbs'][] = $this->title;
$this->registerCssFile('@web/css/appeal/appeal.css?v=5', ['position' => yii\web\View::POS_BEGIN]);
$this->registerJsFile('@web/js/appeal/answers.js?v=5', ['position' => yii\web\View::POS_END]);

if ($openAppeal!=null){

	$script = <<< JS
      var url=  'index.php?r=crm%2Fappeal%2Fdefault%2Fview&id='+$openAppeal;
      var type= 'post';
      ModalBase.ModalOpen(url,false,type);   

 
JS;
//маркер конца строки, обязательно сразу, без пробелов и табуляции
	$this->registerJs($script, yii\web\View::POS_LOAD);
}

$scriptjs = <<< JS
       function changePjax(){
            $.pjax({
                timeout: 4000,
                url: $('#searchForm').attr('action')+'?'+$('#searchForm').serialize()+'&limit='+$("#limit").val(),
                container: '#notes',
                fragment: '#notes',
                scrollTo:false,
           });
                 return false;
        }
        $(document).on('change','.filter-appeal', function() {
           changePjax();
        });
        $(document).on('change','#models-close', function() {
         changePjax();
        });
        
        $(document).on('change','#limit', function() {
         changePjax();
        });
        $('#searchForm').submit(function() {
            return false;
        });
        
          $(document).on('pjax:send', function() {

               var w = $(window);

             $('.loader_wrapper').css("top",(w.height()-$('.loader_wrapper').height())/2+w.scrollTop() + "px");

             $('.loader_wrapper').show();
               $('#loader_place').show();
             
             
           })
           $(document).on('pjax:complete', function() {

              $('.loader_wrapper').hide();
           })
 
JS;
//маркер конца строки, обязательно сразу, без пробелов и табуляции
$this->registerJs($scriptjs, yii\web\View::POS_LOAD);
?>
<!--<section class="content-with-menu content-with-menu-has-toolbar mailbox">-->
<!--    <div class="content-with-menu-container">-->
<!--        <div class="inner-menu-toggle">-->
<!--            <a href="#" class="inner-menu-expand" data-open="inner-menu">-->
<!--                Show Menu <i class="fa fa-chevron-right"></i>-->
<!--            </a>-->
<!--        </div>-->

        <menu id="content-menu" class="inner-menu" role="menu" style="display: none;">
            <div class="nano">
                <div class="nano-content">

                    <div class="inner-menu-content">
                        <a href="/index.php?r=crm%2Fappeal%2Fdefault%2Fcreate#" class="btn btn-block btn-primary btn-md pt-sm pb-sm text-md">
                            <i class="fa fa-envelope mr-xs"></i>
                            Создать обращение
                        </a>

                        <hr class="separator" />

	                    <?php
	                    $form = ActiveForm::begin([
		                    'id'=>'searchForm',
		                    'action' => ['index'],
		                    'method' => 'get',
		                    'options' => ['data-pjax' => true],
		                    'fieldConfig' => [
			                    'template' => ' <div class="form-group" style="margin: 10px 0px 10px 0px;">'
			                                  . '<div class="row">{label}<div class="col-xs-12">{input}</div> </div> </div>',
			                    'labelOptions' => ['class' => 'col-xs-12 control-label'],
			                    'options' => ['class' => 'filter-appeal']
		                    ],
	                    ]);
	                    ?>
                        <h6 class="title pull-left mt-xs">Фильтра:</h6>

	                    <?= $form->field($model, 'category')->dropDownList($model->getSelectCategory(),['data-plugin-selectTwo'=>'','prompt'=>'Выберите категорию']) ?>




	                    <?php ActiveForm::end(); ?>


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
            <div class="mailbox-compose panel-body" style="padding: 40px; margin-top: -80px">

	            <?php yii\widgets\Pjax::begin(['id' => 'new_note']) ?>
	            <?php echo $this->render('grid', [
		            'dataProvider' => $dataProvider,
		            'searchModel' =>$model,
	            ]); ?>
	            <?php Pjax::end(); ?>

            </div>
        </div>
<!--    </div>-->
<!--</section>-->
