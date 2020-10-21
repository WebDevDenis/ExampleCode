<?php

return [
	'modules' => [
		'task' => [
			'class' => 'frontend\modules\task\models\AccessTask',
			'route'=>'/task/task/view',
			'buttons'=>'\common\widgets\views\access\Task',
			'model'=> 'frontend\modules\task\models\Task',
		],
		'appeal'=>[
			'class'=>'frontend\modules\crm\modules\appeal\models\AccessAppeal',
			'model'=>'frontend\modules\crm\modules\appeal\models\AppealItems',
		],
		'taskButton' => [
			'class' => '\common\widgets\views\access\Task',
		],
		'attestation' => [
			'class' => 'frontend\modules\study\modules\attestation\Module',
		],

	]

];