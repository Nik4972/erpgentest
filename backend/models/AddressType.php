<?php

namespace backend\models;

use Yii;
use backend\ErpGroupModel;

/**
 * This is the model class for table "address_type".
 *
 * @property string $id
 * @property string $notion
 * @property string $type
 * @property integer $status
 * @property string $parent
 * @property integer $group
 *
 * @property AddressType $group
 * @property AddressType[] $addressTypes
 */
class AddressType extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'address_type';
    }
    
    const withGroups = 1;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['type'], 'required'],
            [['type'], 'string'],
            [['predefined', 'status', 'parent', 'group'], 'integer'],
            [['notion'], 'string', 'max' => 255],
            [['notion'], 'required'],
            [['code'], 'string', 'max' => 255],
            [['notion', 'code'], 'unique'],
            [['parent'], 'exist', 'skipOnError' => true, 'targetClass' => AddressType::className(), 'targetAttribute' => ['parent' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'notion' => 'Notion',
            'type' => 'Type',
            'status' => 'Status',
            'parent' => 'Group ID',
            'group' => 'Is Group',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getGroup()
    {
        return $this->hasOne(AddressType::className(), ['id' => 'parent']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAddressTypes()
    {
        return $this->hasMany(AddressType::className(), ['parent' => 'id']);
    }
    
    
    /**
     * @return array of available columns for list form
     */
    public function getColumns()
    {
        $columns = [
        'id' => ['notion' => 'ID', 'description' => '', 'type' => 'int', 'default' => '', 'periodic' => 0, 'purpose' => "both", 'index' => 1,
            'required_to_fill' => 1, 'show_in_default_list_form' => 0, 'system' => 1, 'relations' => '��� ������������ ������� � ������� �����', 'hide'=>1],
        'code' => ['notion' => 'Code', 'description' => '�������� �������', 'type' => 'varchar', 'default' => '', 
            'periodic' => 1, 'purpose' => "both",'index' => 1, 'required_to_fill' => 1, 'show_in_default_list_form' => 1, 
            'system' => 0, 'relations' => '��� ������������ �������', 'always_visible'=>1],
        'notion' => ['notion' => 'Notion', 'description' => '��� �� ������', 'type' => 'varchar', 'default' => '', 'periodic' => 1, 'purpose' => "both",
            'index' => 1, 'required_to_fill' => 1, 'show_in_default_list_form' => 1, 'system' => 0, 'relations' => '��� ������������ �������', 'always_visible'=>1],
        /*'description' => ['notion' => '������ �������� �������', 'description' => '������ ��������', 'type' => 'varchar', 'default' => '', 'periodic' => 0, 'purpose' => "group",
            'index' => 0, 'required_to_fill' => 0, 'show_in_default_list_form' => 0, 'system' => 0, 'relations' => '��� ������������ �������'],*/
        'group' => ['notion' => 'Is Group', 'description' => '�������� �� ������ ������ �������', 'type' => 'int', 'default' => '0', 'periodic' => 1, 'purpose' => "???",
            'index' => 1, 'required_to_fill' => 1, 'show_in_default_list_form' => 0, 'system' => 0, 'relations' => '��� ������������ �������', 'hide'=>1],
        'parent' => ['notion' => 'Group', 'description' => '������� ��������', 'type' => 'int', 'default' => '0', 'periodic' => 1, 'purpose' => "???",
            'index' => 1, 'required_to_fill' => 1, 'show_in_default_list_form' => 0, 'system' => 0, 'relations' => '��� ������������ �������'],
        /*'predefined' => ['notion' => '���������������� ������', 'description' => '������ ��-���������', 'type' => 'int', 'default' => '0', 'periodic' => 1, 'purpose' => "???",
            'index' => 1, 'required_to_fill' => 1, 'show_in_default_list_form' => 0, 'system' => 0, 'relations' => '��� ������������ �������', 'hide'=>1],*/
         'status' => ['notion' => 'Status', 'description' => '������ �������(1 - ����������, 2 - �� ����������, 3 - �������)', 'type' => 'int', 'default' => '1', 'periodic' => 1, 'purpose' => "???",
            'index' => 1, 'required_to_fill' => 1, 'show_in_default_list_form' => 1, 'system' => 0,'relations' => '��� ������������ �������'],
        /// �������� � ������������ ����
         /*'date_create' => ['notion' => '���� ��������', 'description' => '���� �������� �������', 'type' => 'datetime', 'default' => 'now', 'periodic' => 1, 'purpose' => "???",
            'index' => 0, 'required_to_fill' => 1, 'show_in_default_list_form' => 1, 'system' => 1,'relations' => '��� ������������ �������'],
        'date_update' => ['notion' => '���� ���������', 'description' => '���� ��������� �������', 'type' => 'datetime', 'default' => 'now', 'periodic' => 1, 'purpose' => "???",
            'index' => 0, 'required_to_fill' => 1, 'show_in_default_list_form' => 1, 'system' => 1,'relations' => '��� ������������ �������'],*/

         'type' => ['notion' => 'Type', 'description' => '������ �������(1 - ����������, 2 - �� ����������, 3 - �������)', 'type' => 'enum', 'default' => '1', 'periodic' => 1, 'purpose' => "???",
            'index' => 1, 'required_to_fill' => 1, 'show_in_default_list_form' => 1, 'system' => 0,'relations' => '��� ������������ �������', 'enum' => 'AddressTypes'],
        ];
        
        if (!$this::withGroups)
            $columns['parent']['hide'] = 1;
        
        return $columns;
    }

    public function delete()
    {
        $connection = $this->getDb();
        $ids = [$this->id];
        do {
            $found = false;
            $command = $connection->createCommand('SELECT `id` FROM `'.$this->tableName().'` WHERE `parent`='.$this->id.' AND `group`=1');
            $groups = $command->queryAll();
            $found = count($groups);
            foreach ($groups as $row)
                $ids[] = $row['id'];
        } while ($found);
        $ids = implode(',', $ids);
        return $connection->createCommand('UPDATE `'.$this->tableName().'` SET `status` = 3 WHERE `parent` IN ('.$ids.') OR `id` IN ('.$ids.')')->execute();
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
    
    public function getGroups($prefix = '--')
    {
        $groups = [];
        $index = [];

        $connection = $this->getDb();
        
        $ids = false;
        $level = '';
        $level_num = 0;
        do {
            $rows = $connection->createCommand('SELECT `id`, `notion`, `parent` FROM `'.$this->tableName().'` WHERE `parent` '
                .($ids ? 'IN ('.implode(',', $ids).')' : 'IS NULL').' AND `group`=1 AND `status`=1')->queryAll();
            $ids = [];
            foreach ($rows as $row) {
                $ids[] = $row['id'];
                
                if (!isset($index[$row['parent']])) {
                    $groups[$row['id']] = $level.$row['notion'];
                    $groups['level'.$row['id']] = $level_num;
                    $groups['rows'.$row['id']] = [];
                    $index[$row['id']] = &$groups['rows'.$row['id']];
                } else {
                    $index[$row['parent']][$row['id']] = $level.$row['notion'];
                    $index[$row['parent']]['level'.$row['id']] = $level_num;
                    $index[$row['parent']]['rows'.$row['id']] = [];
                    $index[$row['id']] = &$index[$row['parent']]['rows'.$row['id']];
                }
            }
            $level .= $prefix;
            $level_num ++;
        } while ($ids);
        
        $this->_groups = [];

        array_walk_recursive($groups, array($this, 'prepareGroups'));
        
        return $this->_groups;
    }
    protected $_groups;
    protected $_last_id = 0;
    protected function prepareGroups($item, $key)
    {
        if (is_int($key)) {
            $this->_groups[$key] = ['notion' => $item, 'id' => $key];
            $this->_last_id = $key;
        }
        else {
            $this->_groups[$this->_last_id]['level'] = $item;
        }
    }
}
