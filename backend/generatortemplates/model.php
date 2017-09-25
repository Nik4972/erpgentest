<?php
echo '<', '?php';
$className = \backend\ErpGenerator::generateClassName($name_tables['name']); //ucfirst($name_tables['notion']);
$moduleName = $name_tables['module'] ? $name_tables['module'] : 'core';
?>

namespace backend\modules\<?= $moduleName ?>\models;

use Yii;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;

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
     * @return notion of table Reference
     */
    public static function tableNotion()
    {
        return Yii::t('app', '<?= $name_tables['notion'] ?>');
    }

    /**
     * @inheritdoc
     */
     <?php
        $rules = $required = $varchar = $digital = $string = "";
        $enumns = '';
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
            
            $name_tables['columns'][$name]['type'] = $type; // hack to replace types like a 'varchar(xx)' to simple 'varchar'
            
            if ($name == 'status')
                continue;
            
            switch($type){
                case "varchar":{ $varchar .= "['$name', 'string', 'max' => $size],"; break;}
                case 'text' : $text .= "'$name',";  break;
                case 'int'  : $digital .= "'$name',"; break;
                case 'decimal': $number .= "'$name',"; break;
                case 'enum': $enumns .= "['$name', 'in', 'range' => ".var_export(\backend\ErpEnums::$$attr['enum'], true).'],';break;
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
            $rules .= "[[$text],'string'],";
        }
        if (!empty($digital)){
            $rules .= "[[$digital],'integer'],";
        }
        $rules .= $enumns;
        
        ?>
    public function rules()
    {
        return [<?=substr($rules,0,-1)?>, ['status', 'in', 'range'=>[1, 2, 3]]];
    }

    /**
     * @inheritdoc
     */
     <?php
     $label="";
      foreach ($name_tables['columns'] as $name=>$attr){
            $notion = $attr['notion'];
            $str = "'$name' => Yii::t('app', '$notion'),";
            //$str = "'$notion' => '$notion',";
            $label.= $str;
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
    public function get<?= \backend\ErpGenerator::generateClassName($attr['relation']) ?>()
    {
        return $this->hasOne(<?=\backend\ErpGenerator::generateClassName($attr['relation'])?>::className(), ['id' => '<?=$name?>']);
    }
<?php }}?>

    /**
     * @inheritdoc
     * @return <?= $className ?>Query the active query used by this AR class.
     */
    /*public static function find()
    {
        return new <?= $className ?>Query(get_called_class());
    }*/
    
    public function behaviors()
    {
        return [
            'history' => [
            'class' => 'backend\behaviors\History', //класс для поведения
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

    public function getParentGroup()
    {
        return $this->hasOne(self::className(), ['id' => 'parent']);
    }

    /**
     * @return array of colums definitions (info going from MySQL _ref_columns + additional info from the generator like 'relation', 'enum')
     */
    public function getColumns()
    {
        //$columns = unserialize('<?= str_replace('\'', '\\\'', serialize($name_tables['columns'])) ?>');
        $columns = <?php var_export($name_tables['columns']) ?>;
        
        if (!self::withGroups)
            $columns['parent']['hide'] = 1;
        
        return $columns;
    }

    /**
     * @return flat array of groups but ordered like a tree
     */
    public function getGroupsTree($patterns = [], $params = [])
    {
        $groups = [];
        $index = [];
       
        $connection = $this->getDb();
        
        $ids = false;
        do {
            $rows = $connection->createCommand('SELECT `id`, `notion`, `parent` FROM `'.$this->tableName().'` WHERE `parent` '
                .($ids ? 'IN ('.implode(',', $ids).')' : 'IS NULL').' AND `group`=1 AND `status`=1')->queryAll();
            $ids = [];
            foreach ($rows as $row) {
                $ids[] = $row['id'];
                
                $rowParams = $params;
                foreach ($patterns as $tmp) {
                    if (isset($tmp['function'])) {
                        $tmp = $tmp['function']($row, $tmp);
                        $rowParams = array_merge($rowParams, $tmp);
                    }
                    else
                        $rowParams[$tmp['attr']] = str_replace($tmp['var'], $row[$tmp['column']], $tmp['template']);
                }

                if (!isset($index[$row['parent']])) {
                    $tmp = ['text' => $row['notion'], 'id' => $row['id'], 'nodes' => []];
                    $tmp = array_merge($tmp, $rowParams);
                    $groups[] = $tmp;
                    $index[$row['id']] = &$groups[count($groups)-1]['nodes'];
                } else {
                    $tmp = ['text' => $row['notion'], 'id' => $row['id'], 'nodes' => []];
                    $tmp = array_merge($tmp, $rowParams);
                    $index[$row['parent']][] = $tmp;
                    $index[$row['id']] = &$index[$row['parent']][count($index[$row['parent']])-1]['nodes'];
                }
            }
        } while ($ids);
        
        return $groups;
    }
}
