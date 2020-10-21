<?php

namespace frontend\modules\crm\models\search;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use frontend\modules\crm\models\CrmClients;

/**
 * searchCrmClients represents the model behind the search form of `frontend\modules\crm\models\CrmClients`.
 */
class searchCrmClients extends CrmClients
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'date_created', 'type'], 'integer'],
            [['name', 'surname', 'patronymic'], 'safe'],
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
        $query = CrmClients::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
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
            'date_created' => $this->date_created,
            'type' => $this->type,
        ]);

        $query->andFilterWhere(['like', 'name', $this->name])
            ->andFilterWhere(['like', 'surname', $this->surname])
            ->andFilterWhere(['like', 'patronymic', $this->patronymic]);

        return $dataProvider;
    }
}
