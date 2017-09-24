<?php

namespace backend\models;

use Yii;
use yii\base\Model;
use backend\models\AddressType;
use backend\ErpGroupModelSearch;
use yii\db\Query;

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
        /*$rules = parent::rules();
        $rules[] = [['search'], 'safe'];
        return $rules;*/

        return [
            [['parent', 'group'], 'integer'],
            [['predefined', 'code', 'notion', 'type', 'search'], 'safe'],
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
    
}
