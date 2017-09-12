<?php

namespace backend\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\AddressType;
use backend\ErpGroupModelSearch;

/**
 * AddressTypeSearch represents the model behind the search form about `backend\models\AddressType`.
 */
class AddressTypeSearch extends AddressType
{
    use ErpGroupModelSearch;
    public $search = '';

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['group_id', 'is_group'], 'integer'],
            [['title', 'type', 'group.title', 'search'], 'safe'],
            ['status', 'in', 'range' => [1, 2, 3, 4]],
        ];
    }

    /**
     * @inheritdoc
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
        $query = AddressType::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);
        
        $query->joinWith(['group' => function($query) { $query->from(['group' => $this->tableName()]); }]);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere(['=', $this->tableName().'.type', $this->type]);
        if ($this->is_group == 1) {
            if ($this->type)
                $query->orFilterWhere([$this->tableName().'.is_group' => 1]);
            $query->andWhere([$this->tableName().'.group_id' => ($this->group_id ? intval($this->group_id) : null)]);
        } else {
            $query->andWhere([$this->tableName().'.is_group' => '0']);
        }

        if (!$this->status)
            $this->status = 1;
        elseif ($this->status == 4) // all
            $this->status = null;

        $query->andFilterWhere([
            $this->tableName().'.status' => $this->status,
        ]);
        
        if (isset($_GET['search']) && strlen($_GET['search'])) {
            $this->search = $_GET['search']{0};
            $query->andWhere(['like', $this->tableName().'.title', $_GET['search']{0}.'%', false]);
        }
        $query->andFilterWhere(['like', $this->tableName().'.title', $this->title]);

        return $dataProvider;
    }
}
