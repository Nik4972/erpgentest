<?php

echo '<', '?php';
$className = ucfirst($name_tables['notion']);
$moduleName = $name_tables['module'] ? $name_tables['module'] : 'core';
$searchModelClass = $className."Search";
?>

namespace backend\modules\<?= $moduleName ?>\models;

use Yii;
use backend\modules\<?= $moduleName ?>\models\<?= $className ?>;
use backend\ErpGroupModelSearch;
use yii\data\ActiveDataProvider;
use yii\db\Query;

/**
 * <?= $searchModelClass ?> represents the model behind the search form about `<?= $className ?>`.
 */
class <?= $searchModelClass ?> extends <?= $className ?>

{
    public $search = '';
    
    /**
     * @inheritdoc
     */
    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return parent::scenarios();
    }

    public function rules()
    {
        $rules = parent::rules();
        unset($rules[0]); // little hack: assume the 'required' validator is first in the list of rules
        // or change it with including here the 'safe' validator for all columns
        $rules[] = [['search'], 'safe'];
        return $rules;
        /*return [
            [['parent', 'group'], 'integer'],
            [['predefined', 'code', 'notion', 'search'], 'safe'],
            ['status', 'each', 'rule' => ['in', 'range' => [1, 2, 3]]],
        ];*/
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

<?php 
    $defaultOrder="";
    $filter = [];
 foreach ($name_tables['columns'] as $name=>$attr){
    if ((isset($attr['hide']) && $attr['hide']) || in_array($name, ['parent', 'status', 'code', 'notion', 'group', 'predefined', 'date_create', 'date_update'])) // skip known (common) columns
        continue;
        
        /*
        if (($attr['order'] == 'SORT_ASC') || ($attr['order'] == 'SORT_DESC')){ // currently there is no $attr['order'] 
            $defaultOrder[] .= "['$name' => ".$attr['order']."]";
        }
         Пока не знаю как сделать поиск если надо по нескольким группам или статусам
        if(($name=='status') || ($name=='group')){
            $filter[] = ['in', "'$name'", "$this->".$name];
        }
        else
         * 
         */
            {
            if ($attr['type']== "int"){
                $filter[] = "->andFilterWhere(['$name' => ".'$this->'."$name])";
            }
            else{
               $filter[] = "->andFilterWhere(['like', '$name', ".'$this->'."$name])";
            }
        }
        
        
    }
    ?>
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort'=> ['defaultOrder' => ['id'=>SORT_DESC, 'code'=>SORT_DESC]]
        ]);

        $this->load($params);
        
        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        if (!$this->status)
            $this->status = [1];
         // TODO: add code for $this->group mode that will check elements status over each group subtree.
         // So with filter status =2 =3 groups will be displayed even with own status=1 but when they have child elements/groups with different status
        $query->andWhere(['in', 'status', $this->status]);
        
        // grid filtering conditions will be elevated in template for each column by its type
        $query->andFilterWhere(['=', 'code', $this->code]);

        <?php if ($filter) echo '$query', implode("\r\n              ", $filter), ';' ?>
        
        if ($this->group == 1) {
            if ($this->type || $this->code) // exclude columns of 'element' kind for groups
                $query->orFilterWhere(['group' => 1]);

            $query->andWhere(['parent' => ($this->parent ? intval($this->parent) : null)]);
        } else {
            $query->andWhere(['group' => '0']);
        }

        if (isset($params['search']) && strlen($params['search'])) {
            if ($params['search'] == 'nonalpha') {
                $this->search = 'nonalpha';
                $query->andWhere(['NOT REGEXP', 'notion', '^[[:alpha:]]']);
            } else {
                $this->search = $params['search'];
                $query->andWhere(['like', 'notion', $params['search'].'%', false]);
            }
        }
        $query->andFilterWhere(['like', 'notion', $this->notion]);

        return $dataProvider;
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
    public function getGroupsTree(){
        
    }
}
