<?php

namespace backend\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use yii\data\ArrayDataProvider;
use backend\models\AddressType;
use backend\ErpGroupModelSearch;
use yii\db\Query;

/**
 * AddressTypeSearch represents the model behind the search form about `backend\models\AddressType`.
 */
class AddressTypeSearch extends AddressType
{
    public $search = '';

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['parent', 'group'], 'integer'],
            [['predefined', 'code', 'notion', 'type', 'group.notion', 'search'], 'safe'],
            ['status', 'each', 'rule' => ['in', 'range' => [1, 2, 3]]],
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
    * @return array of available distinct values in table column
    */
    public function getFilterValues($column)
    {
        $columns = $this->getColumns();
        if (!$this->group && $columns[$column]['purpose'] == 'group') // group column asked in nongroups view
            return [];
        
        $sql = [];

        if (is_array($this->status))
            $str = '`status` IN ('.implode(',', $this->status).')';
        else
            $str = '`status` = '.($this->status ? $this->status : 1);
        $sql[] = $this->group && $columns[$column]['purpose'] != 'element' ? '('.$str.' OR `group` = 1)' : $str;
        
        if ($columns[$column]['purpose'] == 'element' || !$this->group)
            $sql[] = '`group` = 0';
        elseif ($columns[$column]['purpose'] == 'group')
            $sql[] = '`group` = 1';

        /*if ($this->group == 1) {
            if ($columns[$column]['purpose'] == 'element')
                $sql[] = '(`group` = 1 OR `parent` '.($this->parent ? '= '.intval($this->parent) : 'IS NULL').')';
            else
                $sql[] = '`parent` '.($this->parent ? '= '.intval($this->parent) : 'IS NULL');
        } else {
            $sql[] = '`group` = 0';
        }*/
        
        $connection = $this->getDb();
        $command = $connection->createCommand('SELECT DISTINCT `'.$column.'` FROM `'
            .$this->tableName().'`'.($sql ? ' WHERE '.implode(' AND ', $sql) : '').' ORDER BY `'.$column.'`');
        $rows = $command->queryAll(); // TODO: add WHERE for status and/or group if needed 
        $rows = yii\helpers\ArrayHelper::map($rows, $column, $column);
        
        return $rows;
    }
    
    /**
    * @return array of chars/letters available for search by notion column (first character of notion).
    * 'nonalpha' value means there are one or many non alphabet characters (digits, punctuations)
    */
    public function getFilterAlphabet()
    {
        $connection = $this->getDb();
        $command = $connection->createCommand('SELECT substr(notion,1,1) as letter, substr(notion,1,1) REGEXP \'[[:alpha:]]\' as is_alpha FROM `'
            .$this->tableName().'` GROUP BY substr(notion,1,1) ORDER BY letter');
        $rows = $command->queryAll();  // TODO: add WHERE for status and/or group if needed 

        $rows = yii\helpers\ArrayHelper::map($rows, function ($element) {
            return $element['is_alpha'] ? $element['letter'] : 'nonalpha';
        }, 'is_alpha');
        $rows = array_keys($rows);
        return $rows;
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
            'sort'=> ['defaultOrder' => ['id'=>SORT_DESC, 'code'=>SORT_DESC]]
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
        if ($this->group == 1) {
            if ($this->type)
                $query->orFilterWhere([$this->tableName().'.group' => 1]);
            $query->andWhere([$this->tableName().'.parent' => ($this->parent ? intval($this->parent) : null)]);
        } else {
            $query->andWhere([$this->tableName().'.group' => '0']);
        }

        if (!$this->status)
            $this->status = [1];

        $query->andWhere(['in', $this->tableName().'.status', $this->status]);
        
        if (isset($_GET['search']) && strlen($_GET['search'])) {
            //echo '<pre>';print_r(urldecode($_GET['search']));die;
            if ($_GET['search'] == 'nonalpha') {
                $this->search = 'nonalpha';
                $query->andWhere(['NOT REGEXP', $this->tableName().'.notion', '^[[:alpha:]]']);
            } else {
                /*$this->search = $_GET['search']{0};
                $query->andWhere(['like', $this->tableName().'.notion', $_GET['search']{0}.'%', false]);*/
                $this->search = $_GET['search'];
                $query->andWhere(['like', $this->tableName().'.notion', $_GET['search'].'%', false]);
            }
        }
        $query->andFilterWhere(['like', $this->tableName().'.notion', $this->notion]);

        return $dataProvider;
    }
}
