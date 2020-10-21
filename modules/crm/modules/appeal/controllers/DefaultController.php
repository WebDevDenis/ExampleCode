<?php

namespace frontend\modules\crm\modules\appeal\controllers;

use frontend\modules\access\components\CAccessAction;
use Yii;
use frontend\modules\crm\modules\appeal\models\AppealItems;
use frontend\modules\crm\modules\appeal\models\base\AppealAnswer;
use frontend\modules\crm\modules\appeal\models\search\SearchAppealItems;
use frontend\controllers\FrontendController;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * DefaultController implements the CRUD actions for AppealItems model.
 */
class DefaultController extends FrontendController
{
	/**
	 * {@inheritdoc}
	 */
	public function behaviors()
	{
		return [
			'verbs' => [
				'class' => VerbFilter::className(),
				'actions' => [
					'delete' => ['POST'],
				],
			],
		];
	}

	/**
	 * Lists all AppealItems models.
	 * @return mixed
	 */
	public function actionIndex()
	{

		$openAppeal = !empty(Yii::$app->request->get('id')) ? (int)Yii::$app->request->get('id') : null;
		$model = new SearchAppealItems();
		$dataProvider = $model->search(Yii::$app->request->queryParams);
		return $this->render('index', compact('model','dataProvider','openAppeal'));
	}

	/**
	 * Displays a single AppealItems model.
	 * @param integer $id
	 * @return mixed
	 * @throws NotFoundHttpException if the model cannot be found
	 */
	public function actionView(int $id)
	{
		$model=$this->findModel($id);

		$access_view = (new CAccessAction())->applyAction('ViewingAppeal',$model);
		if($access_view==false){
			return $this->renderPartial('not_right_view');
		}

		$modelAnswer=new AppealAnswer();
		$modelAnswer->id_appeal=$model->id;
		$sendAppealAnswer = (new CAccessAction())->applyAction('ViewingAppealAnswer',$model);
		return $this->renderAjax('view', [
			'model' => $model,
			'modelAnswer' => $modelAnswer,
			'sendAppealAnswer'=>$sendAppealAnswer
		]);
	}

	/**
	 * Creates a new AppealItems model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 * @return mixed
	 */
	public function actionCreate()
	{
		$model = new AppealItems();
		$model->channel=1;
		$model->status=1;
		$model->created_date=time();
		$model->load(Yii::$app->request->post());
		$access =(new CAccessAction())->applyAction("CreatingAppeal", $model);
		if ($access  && $model->save()) {
			return $this->redirect(['index', 'id' => $model->id]);
		}


		return $this->render('create', [
			'model' => $model,
		]);
	}


	public function actionAddAnswer(){

		$model=$this->findModel(Yii::$app->request->post('AppealAnswer')['id_appeal']);
		$sendAppealAnswer = (new CAccessAction())->applyAction('sendAppealAnswer',$model);
		if($sendAppealAnswer==false){
			return $this->renderPartial('not_right_send');
		}
		$modelAnswer=new AppealAnswer();
		$modelAnswer->id_author=Yii::$app->user->identity->id;

		if ($modelAnswer->load(Yii::$app->request->post()) && $modelAnswer->save()) {
			return $this->renderPartial('appealItem/_answers', ['model' => $model]);
		}

	}
	public function actionAddCall(){

		$model=$this->findModel((int)Yii::$app->request->get('id'));
		$modelAnswer=new AppealAnswer();
		$modelAnswer->id_author=Yii::$app->user->identity->id;
		$modelAnswer->text = 'Дата и время звонка:'.date('d.m.Y H:i', time());
		$modelAnswer->date_created=time();
		$modelAnswer->chanel=6;
		$modelAnswer->id_appeal=(int)Yii::$app->request->get('id');


		if ($modelAnswer->save()) {
			return $this->renderPartial('appealItem/_answers', ['model' => $model]);
		}

	}


	/**
	 * Finds the AppealItems model based on its primary key value.
	 * If the model is not found, a 404 HTTP exception will be thrown.
	 * @param integer $id
	 * @return AppealItems the loaded model
	 * @throws NotFoundHttpException if the model cannot be found
	 */
	protected function findModel($id)
	{
		if (($model = AppealItems::findOne($id)) !== null) {
			return $model;
		}

		throw new NotFoundHttpException('The requested page does not exist.');
	}
}
