<?php

namespace frontend\modules\crm\modules\appeal\models\search;

use frontend\modules\task\models\Task;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use frontend\modules\crm\modules\appeal\models\AppealItems;

/**
 * SearchAppealItems represents the model behind the search form of `frontend\modules\crm\modules\appeal\models\AppealItems`.
 */
class SearchAppealItems extends AppealItems
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'channel', 'category', 'user_id', 'client_id', 'phone', 'created_date', 'status', 'department_id', 'post_department_id'], 'integer'],
            [['text', 'title', 'email'], 'safe'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $query = AppealItems::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);
	    $dataProvider->setSort([
		    'attributes' => [

			    'id' => [
				    'asc' => [AppealItems::tableName() . '.id' => SORT_ASC],
				    'desc' => [AppealItems::tableName() . '.id' => SORT_DESC],
			    ],

		    ],
		    'defaultOrder' => ['id'=> SORT_DESC]
	    ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
    }

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'channel' => $this->channel,
            'category' => $this->category,
            'user_id' => $this->user_id,
            'client_id' => $this->client_id,
            'phone' => $this->phone,
            'created_date' => $this->created_date,
            'status' => $this->status,
            'department_id' => $this->department_id,
            'post_department_id' => $this->post_department_id,
        ]);

        $query->andFilterWhere(['like', 'text', $this->text])
            ->andFilterWhere(['like', 'title', $this->title])
            ->andFilterWhere(['like', 'email', $this->email]);

        return $dataProvider;
    }
}
