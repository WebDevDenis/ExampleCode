<?php

namespace frontend\modules\crm\controllers;

use Yii;
use frontend\modules\crm\models\CrmClients;
use frontend\modules\crm\models\search\searchCrmClients;
use frontend\controllers\FrontendController;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * ClientController implements the CRUD actions for CrmClients model.
 */
class ClientController extends FrontendController
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
     * Lists all CrmClients models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new searchCrmClients();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single CrmClients model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

	public function actionSearchClient()
	{
		$text= Yii::$app->request->get('term')['term'];
		$query= CrmClients::find()
		    ->orWhere(['like','name',$text])
			->orWhere(['like','surname',$text])
			->orWhere(['like','patronymic',$text])->all();

		$result=[];
		foreach ($query as $key=> $item){


			$result['items'][$key]['id']=$item->id;
			$result['items'][$key]['text']=(string)$item->surname.' '.(string)$item->name.' '.(string)$item->patronymic;
		}

		return json_encode($result);
	}
    /**
     * Creates a new CrmClients model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
	public function actionAjaxCreate(){

		$model = new CrmClients();

		$ajax=Yii::$app->request->get('CrmClients');

		if(!empty($ajax)){
			$model->date_created=time();
			$model->name =$ajax['name'];
			$model->surname =$ajax['surname'];
			$model->patronymic =$ajax['patronymic'];
			$model->type =$ajax['type'];
			if($model->save()){
				$client['result']['id']=$model->id;
				$client['result']['text']=$model->getFullName();
				$client['result']['selected']=true;
				return json_encode($client)  ;

			}
		}
		return false;
	}
    public function actionCreate()
    {
        $model = new CrmClients();


	    if(Yii::$app->request->get("modal")==1){
		    return  $this->renderAjax('create', [
			    'model' => $model, ]);
	    }
    }

    /**
     * Updates an existing CrmClients model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing CrmClients model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the CrmClients model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return CrmClients the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = CrmClients::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
