<?php
echo '<', '?php';
$className = ucfirst($name_tables['notion']);
$moduleName = $name_tables['module'] ? $name_tables['module'] : 'core';
?>

namespace backend\modules\<?= $moduleName ?>\models;

use Yii;
use yii\behaviors\TimestampBehavior;
/**
 * <?= $className ?> represents the model behind the search form about `backend\<?= $moduleName ?>\models\<?= $className ?>.
 */
class <?= $className ?> extends \yii\db\ActiveRecord
{
    const withGroups = <?= $name_tables['hierarchy'] ? 1 : 0 ?>;
    const STATUS_ACTUAL = 1;
    const STATUS_NONACTUAL = 2;
    const STATUS_DELETED = 3;
/**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '<?= $name_tables['name'] ?>';
    }

    /**
     * @inheritdoc
     */
     <?php
        $rules = $required = $varchar = $digital = $string = "";
        foreach ($name_tables['columns'] as $name=>$attr){
            if ($attr['required']){
                $required .= "'$name',";
            }
            if (strpos($attr['type'],"(")){
                $ptn = "/([^\)]+)\((.*)\)/";
                //$str = "varchar(256)";
                preg_match($ptn, $attr['type'], $matches); 
                $type = $matches[1];
                $size = $matches[2];
            }
            else{
                $type = $attr['type'];
            }
            switch($type){
                case "varchar":{ $varchar .= "['$name', 'string', 'max' => $size],"; break;}
                case 'text' : $text .= "'$name',";  break;
                case 'int'  : $digital .= "'$name',"; break;
                case 'decimal':$number .= "'$name',"; break;
            }
            
    //        'decimal(19,2)' 'varchar(33)' 'float' 'enum.Переменной из базового файла' 'date'=int
        }
        if (!empty($required)){
            $rules .= "[[$required],'required'],";
        }
        if (!empty($varchar)){
            $rules .= $varchar;
        }
        if (!empty($text)){
            $rules .= "[[$text],'string']";
        }
        if (!empty($digital)){
            $rules .= "[[$digital],'integer'],";
        }
        
        ?>
    public function rules()
    {
        return [<?=substr($rules,0,-1)?>];
    }

    /**
     * @inheritdoc
     */
     <?php
      foreach ($name_tables['columns'] as $name=>$attr){
            $notion = $attr['notion'];
            $ladel[$name] = "Yii::t('app', '$notion')";
        }
     ?>
    public function attributeLabels()
    {
        return [<?=$label?>];
    }
<?php foreach ($name_tables['columns'] as $name=>$attr){
             if ($attr['relation']){ ?>

    /**
     * @return \yii\db\ActiveQuery
     */
    public function get<?= $attr['relation'] ?>()
    {
        return $this->hasOne(<?=$attr['relation']?>::className(), ['<?=$name?>' => 'id']);
    }
<?php }}?>

    /**
     * @inheritdoc
     * @return <?= $className ?>Query the active query used by this AR class.
     */
    public static function find()
    {
        return new <?= $className ?>Query(get_called_class());
    }
    public function behaviors()
    {
        return [
            'history' => [
            'class' => 'common\behaviors\History', //класс для поведения
            ],
            [
                'class' => TimestampBehavior::className(),
                'attributes' => [
                    ActiveRecord::EVENT_BEFORE_INSERT => ['date_create', 'date_update'],
                    ActiveRecord::EVENT_BEFORE_UPDATE => ['date_update'],
                ],
            ],
        ];
    }
    public function getColumns()
    {
        $columns = unserialize('<?= str_replace('\'', '\\\'', serialize($name_tables['columns'])) ?>');
        
        if (!self::withGroups)
            $columns['parent']['hide'] = 1;
        
        return $columns;
    }
}
