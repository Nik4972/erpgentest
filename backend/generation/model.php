<?php

echo '<', '?php';
$className = ucfirst($name_tables['notion']);
$moduleName = $name_tables['module'] ? $name_tables['module'] : 'core';
?>

namespace backend\<?= $moduleName ?>\models;

use Yii;
use yii\behaviors\TimestampBehavior;
/**
 * <?= $className ?> represents the model behind the search form about `backend\<?= $moduleName ?>\models\<?= $className ?>.
 */
class <?= $className ?> extends \yii\db\ActiveRecord
{
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
     $required = $varchar = $digital = $string = "";
        foreach ($tables['column'] as $name=>$attr){
            if ($attr['required_to_fill']){
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
                case "varchar":{ $varchar[] .= ['$name', 'string', 'max' => $size]; break;}
                case 'text' : $text[] = "'$name',";  break;
                case 'int'  : $digital[] = "'$name',"; break;
                case 'decimal':$number[]= "'$name',"; break;
            }
            
    //        'decimal(19,2)' 'varchar(33)' 'float' 'enum.Переменной из базового файла' 'date'=int
        }
        $rules["required"] = [[$required],'required'];
        $rules["varchar"] = $varchar;
        $rules["string"] = [[$text],'string'];
        $rules["int"] = [[$digital],'integer'];
        ?>
    public function rules()
    {
        return [<?=$rules?>];
    }

    /**
     * @inheritdoc
     */
     <?php
      foreach ($tables['column'] as $name=>$attr){
            $notion = $attr['notion'];
            $ladel[$name] = "Yii::t('app', '$notion')";
        }
     ?>
    public function attributeLabels()
    {
        return [<?=$label?>];
    }
<?php foreach ($tables['column'] as $name=>$attr){
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
}
