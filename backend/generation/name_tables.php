<?php
/*
 * name_tables - имя таблицы из глобальной таблицы ) должно совпадать
 * добавить сортировку по-умолчанию (enum SORT_ASC, SORT_DESC и 0) 
 * добавить связь(relation) (пока один-к-одному)
 */
$tables = [
    'name_tables' => 'banks', 
    'notion' => 'banks',
    'description' => 'list of the banks',
    'group' => 0,
    'module' => 'banks',
    'type' => 'system',
    'columns' => [
    'id' => ['notion' => '', 'description' => '', 'type' => 'int', 'default' => '', 'periodic' => 0, 'purpose' => "both", 'index' => 1,
        'required_to_fill' => 1, 'show_in_default_list_form' => 0, 'system' => 1, 'relations' => 'Имя существующей таблицы с большой буквы'],
    'code' => ['notion' => 'уникальный номер объекта', 'description' => 'Например Артикул', 'type' => 'varchar', 'default' => '', 
        'periodic' => 1, 'purpose' => "both",'index' => 1, 'required_to_fill' => 1, 'show_in_default_list_form' => 1, 'system' => 0, 'relations' => 'Имя существующей таблицы'],
    'notion' => ['notion' => 'имя в интерфейсе', 'description' => 'Имя на экране', 'type' => 'varchar', 'default' => '', 'periodic' => 1, 'purpose' => "both",
        'index' => 1, 'required_to_fill' => 1, 'show_in_default_list_form' => 1, 'system' => 0, 'relations' => 'Имя существующей таблицы'],
    'description' => ['notion' => 'Полное описание объекта', 'description' => 'Полное описание', 'type' => 'varchar', 'default' => '', 'periodic' => 0, 'purpose' => "group",
        'index' => 0, 'required_to_fill' => 0, 'show_in_default_list_form' => 0, 'system' => 0, 'relations' => 'Имя существующей таблицы'],
    'group' => ['notion' => 'Группа', 'description' => 'является ли данная запись группой', 'type' => 'int', 'default' => '0', 'periodic' => 1, 'purpose' => "???",
        'index' => 1, 'required_to_fill' => 1, 'show_in_default_list_form' => 0, 'system' => 0, 'relations' => 'Имя существующей таблицы'],
    'parent' => ['notion' => 'Родитель', 'description' => 'Наличие родителя', 'type' => 'int', 'default' => '0', 'periodic' => 1, 'purpose' => "???",
        'index' => 1, 'required_to_fill' => 1, 'show_in_default_list_form' => 0, 'system' => 0, 'relations' => 'Имя существующей таблицы'],
    'predefined' => ['notion' => 'предопределенная запись', 'description' => 'Записи по-умолчанию', 'type' => 'int', 'default' => '0', 'periodic' => 1, 'purpose' => "???",
        'index' => 1, 'required_to_fill' => 1, 'show_in_default_list_form' => 0, 'system' => 0, 'relations' => 'Имя существующей таблицы'],
     'status' => ['notion' => 'Статус', 'description' => 'Статус объекта(1 - актуальный, 2 - не актуальный, 3 - удалить)', 'type' => 'int', 'default' => '1', 'periodic' => 1, 'purpose' => "???",
        'index' => 1, 'required_to_fill' => 1, 'show_in_default_list_form' => 1, 'system' => 0,'relations' => 'Имя существующей таблицы'],
    /// добавить в описательный файл
     'date_create' => ['notion' => 'Дата создания', 'description' => 'Дата создания объекта', 'type' => 'datetime', 'default' => 'now', 'periodic' => 1, 'purpose' => "???",
        'index' => 0, 'required_to_fill' => 1, 'show_in_default_list_form' => 1, 'system' => 1,'relations' => 'Имя существующей таблицы'],
    'date_update' => ['notion' => 'Дата изменения', 'description' => 'Дата изменения объекта', 'type' => 'datetime', 'default' => 'now', 'periodic' => 1, 'purpose' => "???",
        'index' => 0, 'required_to_fill' => 1, 'show_in_default_list_form' => 1, 'system' => 1,'relations' => 'Имя существующей таблицы'],
        ]
];

// Типовая модель 

namespace app\models;

use Yii;

/**
 * This is the model class for table "{{%name_tables}}".
 *
 * Можно добавить потом - на работу не влияет - для удобства разработки
 * @property integer $id
 * @property string $name
 * @property string $date_from
 * @property string $date_to
 * @property string $time_from
 * @property string $time_to
 * @property string $country
 * @property string $city
 * @property string $title
 * @property string $describe1
 * @property string $price
 * @property string $phone
 * @property string $phone_whats
 *
 * @property NartKursInstructor[] $nartKursInstructors
 * @property NartKursCoach[] $nartKursCoaches
 */
class {$tables['name']} extends \yii\db\ActiveRecord
{
    public static function tableName()
    {
        return "{{".$tables['name']."}}";
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
    {{
        $required = $varchar = $digital = $string = "";
        foreach ($tables['column'] as $name=>$attr){
            if ($attr['required_to_fill']){
                $required .= "'$name',";
            }
            if ($attr['type']=='varchar'){
                $varchar[] .= "'$name',";
            }
            if ($attr['type']=='text'){
                $text[] = "'$name',";
            }
            if ($attr['type']=='int'){
                $digital[] = "'$name',";
            }
        }
        $rules["required"] = [[$required],'required'];
        $rules["varchar"] = [[$varchar],'string', 'max' => 255];
        $rules["string"] = [[$text],'string'];
        $rules["int"] = [[$digital],'integer'];
       /*
         public function rules()
    {
        return $rules;
        }
        */
    }}
        return [
            "required"=> [['name', 'date_from', 'date_to', 'time_from', 'time_to', 'title', 'describe1', 'price', 'phone_whats',], 'required'],
            //[['date_from', 'date_to', ], 'date', 'format' => 'd-m-yy'],
            "string"=>[['title', 'describe1', 'name' ], 'string'],
            [['price'], 'number'],
            [['country', 'city', 'phone_whats'], 'string', 'max' => 255],
            [['phone_whats'], 'string', 'max' => 20],
            /*['instractor', 'required', 'when' => function($model) {
                return empty($model->coach);
            }],
            ['coach', 'required', 'when' => function($model) {
                return empty($model->instractor);
            }],
             * 
             */
        ];
    }

    /**
     * @inheritdoc
     */
    
    {{
        foreach ($tables['column'] as $name=>$attr){
            $notion = $attr['notion'];
            $ladel[$name] = "Yii::t('app', '$notion')";
        }
    }}
    /*public function attributeLabels()
    {
        return $label;
    }
     * 
     */

    /**
     * @return \yii\db\ActiveQuery
     */
     {{
         foreach ($tables['column'] as $name=>$attr){
             if ($attr['relation']){
                 /*
                  public function get$attr['relation']()
    {
        return $this->hasOne($attr['relation']::className(), ['$name' => 'id']);
    }
                  */
             }
         }
     }}
// Search файл      
    foreach ($tables['column'] as $name=>$attr){
        $defaultOrder=[];
        $filter =[];
        if (($attr['order'] == 'SORT_ASC') || ($attr['order'] == 'SORT_DESC')){
            $defaultOrder[] = ["'$name'" => $attr['order']];
        }
        $filter[] = ['условие сравнения в зависимости от типа', "'$name'", "$this->$name"];
    }
     {{
         
         /*
         public function search($params)
    {
        $query = $tables['name']::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort' => [
                'defaultOrder' => $defaultOrder
            ],
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere($filter);

        return $dataProvider;
    }*/
     }}
     
    
  
    public static function find()
    {
        return new {$tables['name']}Query(get_called_class());
    }
    
    public function afterSave($insert, $changedAttributes) {
        parent::afterSave($insert, $changedAttributes);
        
    }
    public function afterFind() {
        parent::afterFind();         
    }
}
/*
 * Контроллер
 */

namespace app\controllers;

use Yii;
use app\models\$tables['name'];
use app\models\$tables['name']Search;
//use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;


class {{$tables['name']}}Controller extends Controller
{
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                //'only' => ['logout'],
                'rules' => [
                    [
                        //'actions' => ['logout','index','Nartconfig'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }
/**
     * Lists all <?= $tables['name'] ?> models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new <?= $tables['name']."Search" ?>();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }
}