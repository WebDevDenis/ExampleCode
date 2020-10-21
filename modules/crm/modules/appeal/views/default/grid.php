<?php

use yii\grid\GridView;


?>
<?= GridView::widget([
    'id'=>'notes',
	'dataProvider' => $dataProvider,
	'filterModel' => $searchModel,
	'columns' => [
		[
			'attribute' =>'id',
			'content' => function($data) {
				return '
	                <a href="javascript: void(0)" class="modalStart" data-modalrequesttype="post" data-modalrequest="index.php?r=crm%2Fappeal%2Fdefault%2Fview&id='.$data->id.' " >'.$data->id.'</a>
		       ';
			}
		],
		[
			'attribute' => 'title',
			'content' => function($data) {

				return '
	                <a href="javascript: void(0)" class="modalStart" data-modalrequesttype="post" data-modalrequest="index.php?r=crm%2Fappeal%2Fdefault%2Fview&id='.$data->id.' " >'.$data->title.'</a>
		       ';
			}
		],
		[
			'attribute' => 'category',
			'content' => function($data) {
				return $data->appealCategory->name;
			}
		],
		[
			'attribute' => 'client_id',
			'content' => function($data) {
				if ($data->client_id == null) {
					return '-';
				}
				return $data->clientUser->fullName;
			}
		],
		'email',
		'phone',
		[
			'attribute' => 'created_date',
			'content' => function($data) {
				if ($data->created_date == 0) {
					return '-';
				}
				return date('d.m.Y H:i', $data->created_date);
			}
		],

		[
			'attribute' => 'status',
			'content' => function($data) {
				if ($data->status == null) {
					return '-';
				}
				return $data->appealStatus->name;
			}
		],
		[
			'attribute' => 'user_id',
			'content' => function($data) {
				if ($data->user_id == null) {
					return '-';
				}
				return $data->users->fullName;
			}
		],
		[
			'attribute' => 'department_id',
			'content' => function($data) {
				if ($data->department_id == null) {
					return '-';
				}
				return $data->departments->name;
			}
		],
	],
]); ?>

