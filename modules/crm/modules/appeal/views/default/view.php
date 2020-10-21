<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model frontend\modules\crm\modules\appeal\models\AppealItems */

$this->title = $model->title;
$this->params['breadcrumbs'][] = ['label' => 'Appeal Items', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

\yii\web\YiiAsset::register($this);

?>




    <div class="row" style="width: 1000px; padding: 30px">
        <div class="col-md-7">
            <div class="panel panel-body">

                <h1><?= Html::encode($this->title) ?></h1>

                <div class="well">
				    <?=  $model->text; ?>
                </div>
            </div>
        </div>
        <div class="col-md-5">
            <div class="panel panel-body">
                <table class="table table-striped ">
                    <tr>
                        <td >Номер обращения</td>
                        <td>
                            <strong>
                                <?php
						            echo $model->id;
					            ?>
                            </strong>
                        </td>

                    </tr>
	                <?php
	                if (isset( $model->appealChannel->name)) {
		                ?>
                        <tr>
                            <td>Канал обращения:</td>
                            <td>
                                <strong>   <?php
					                echo $model->appealChannel->name;
					                ?>
                                </strong>
                            </td>

                        </tr>
		                <?php
	                }
	                ?>
	                <?php
	                if (isset($model->clientUser->fullName)) {
		                ?>
                        <tr>
                            <td>Клиент:</td>
                            <td>
                                <strong>   <?php
					                echo $model->clientUser->fullName;
					                ?>
                                </strong>
                            </td>

                        </tr>
		                <?php
	                }
	                ?>
                    <tr>
                        <td>Почта:</td>
                        <td>
                            <strong>   <?php
				                echo $model->email;
				                ?>
                            </strong>
                        </td>

                    </tr>
                    <tr>
                        <td >Телефон:</td>
                        <td>
                            <strong>   <?php
				                echo $model->phone;
				                ?>
                            </strong>
                        </td>

                    </tr>
                    <tr>
                        <td >Дата создания:</td>
                        <td>
                            <strong>   <?php
				                echo date('d.m.Y H:i',  $model->created_date);
				                ?>
                            </strong>
                        </td>

                    </tr>
	                <?php
	                if (isset($model->appealStatus->name)) {
		                ?>
                        <tr>
                            <td>Статус:</td>
                            <td>
                                <strong>   <?php
					                echo $model->appealStatus->name;
					                ?>
                                </strong>
                            </td>

                        </tr>
		                <?php
	                }
	               if (isset($model->departments->name)){
	                ?>
                    <tr>
                        <td >Ответственный отдел:</td>
                        <td>
                            <strong>   <?php
				                echo $model->departments->name;
				                ?>
                            </strong>
                        </td>

                    </tr>
	                <?php
                    }
	                if (isset($model->users->fullName)){
	                ?>
                    <tr>
                        <td >Ответственный сотрудник:</td>
                        <td>
                            <strong>   <?php
				                echo $model->users->fullName;
				                ?>
                            </strong>
                        </td>

                    </tr>
		                <?php
	                }

	                ?>
                </table>

            </div>
        </div>



    </div>
<div id="block-answers" style="padding: 50px">
<?php echo $this->render('appealItem/_answers', ['model' => $model]); ?>
</div>


<?php
if($sendAppealAnswer){
	echo $this->render('appealItem/_formAppealAnswer', ['modelAnswer' => $modelAnswer,'type_contact'=>$model->type_contact]);
} ?>
