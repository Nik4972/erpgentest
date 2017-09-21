<?php

echo '<', '?php';
$className = ucfirst($name_tables['notion']);
$moduleName = $name_tables['module'] ? $name_tables['module'] : 'core';
$searchModelClass = $className."Search";
?>

namespace backend\<?= $moduleName ?>\models;

use Yii;

/**
 * <?= $searchModelClass ?> represents the model behind the search form about `<?= $generator->modelClass ?>`.
 */
class <?= $searchModelClass ?> extends <?= $className ?>

{
    
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
        $query = <?=$className ?>::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

 <?php foreach ($tables['column'] as $name=>$attr){
        $defaultOrder=[];
        $filter =[];
        if (($attr['order'] == 'SORT_ASC') || ($attr['order'] == 'SORT_DESC')){
            $defaultOrder[] = ["'$name'" => $attr['order']];
        }
        /* Пока не знаю как сделать поиск если надо по нескольким группам или статусам
        if(($name=='status') || ($name=='group')){
            $filter[] = ['in', "'$name'", "$this->".$name];
        }
        else
         * 
         */
            {
            if ($attr['type']== "int")
                $filter[] = ["'$name'", "$this->$name"];
            else
               $filter[] = ['like', "'$name'", "$this->".$name];
        }
    }
    ?>
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort' => [
                'defaultOrder' => <?=$defaultOrder?>
            ],
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

       // grid filtering conditions
        $query->andFilterWhere(<?=$filter?>);

        return $dataProvider;
    }
}
