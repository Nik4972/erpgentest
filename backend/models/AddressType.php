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
    use ErpGroupModel;
    
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'address_type';
    }
    
    const withGroups = 1;

    const STATUS_ACTUAL = 1;
    const STATUS_NONACTUAL = 2;
    const STATUS_DELETED = 3;

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
            'parent' => 'Group',
            'group' => 'Is Group',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery parent group
     */
    public function getParentGroup()
    {
        return $this->hasOne(AddressType::className(), ['id' => 'parent']);
    }

    /**
     * @return \yii\db\ActiveQuery list of child records of current group 
     */
    public function getElements()
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
            'required_to_fill' => 1, 'show_in_default_list_form' => 0, 'system' => 1, 'relations' => 'Имя существующей таблицы с большой буквы', 'hide'=>1],
        'code' => ['notion' => 'Code', 'description' => 'Например Артикул', 'type' => 'varchar', 'default' => '', 
            'periodic' => 1, 'purpose' => "both",'index' => 1, 'required_to_fill' => 1, 'show_in_default_list_form' => 1, 
            'system' => 0, 'relations' => 'Имя существующей таблицы', 'always_visible'=>1],
        'notion' => ['notion' => 'Notion', 'description' => 'Имя на экране', 'type' => 'varchar', 'default' => '', 'periodic' => 1, 'purpose' => "both",
            'index' => 1, 'required_to_fill' => 1, 'show_in_default_list_form' => 1, 'system' => 0, 'relations' => 'Имя существующей таблицы', 'always_visible'=>1],
        /*'description' => ['notion' => 'Полное описание объекта', 'description' => 'Полное описание', 'type' => 'varchar', 'default' => '', 'periodic' => 0, 'purpose' => "group",
            'index' => 0, 'required_to_fill' => 0, 'show_in_default_list_form' => 0, 'system' => 0, 'relations' => 'Имя существующей таблицы'],*/
        'group' => ['notion' => 'Is Group', 'description' => 'является ли данная запись группой', 'type' => 'int', 'default' => '0', 'periodic' => 1, 'purpose' => "???",
            'index' => 1, 'required_to_fill' => 1, 'show_in_default_list_form' => 0, 'system' => 0, 'relations' => 'Имя существующей таблицы', 'hide'=>1],
        'parent' => ['notion' => 'Group', 'description' => 'Наличие родителя', 'type' => 'int', 'default' => '0', 'periodic' => 1, 'purpose' => "???",
            'index' => 1, 'required_to_fill' => 1, 'show_in_default_list_form' => 0, 'system' => 0, 'relations' => 'Имя существующей таблицы'],
        /*'predefined' => ['notion' => 'предопределенная запись', 'description' => 'Записи по-умолчанию', 'type' => 'int', 'default' => '0', 'periodic' => 1, 'purpose' => "???",
            'index' => 1, 'required_to_fill' => 1, 'show_in_default_list_form' => 0, 'system' => 0, 'relations' => 'Имя существующей таблицы', 'hide'=>1],*/
         'status' => ['notion' => 'Status', 'description' => 'Статус объекта(1 - актуальный, 2 - не актуальный, 3 - удалить)', 'type' => 'int', 'default' => '1', 'periodic' => 1, 'purpose' => "???",
            'index' => 1, 'required_to_fill' => 1, 'show_in_default_list_form' => 1, 'system' => 0,'relations' => 'Имя существующей таблицы', 'hide'=>1],
        /// добавить в описательный файл
         /*'date_create' => ['notion' => 'Дата создания', 'description' => 'Дата создания объекта', 'type' => 'datetime', 'default' => 'now', 'periodic' => 1, 'purpose' => "???",
            'index' => 0, 'required_to_fill' => 1, 'show_in_default_list_form' => 1, 'system' => 1,'relations' => 'Имя существующей таблицы'],
        'date_update' => ['notion' => 'Дата изменения', 'description' => 'Дата изменения объекта', 'type' => 'datetime', 'default' => 'now', 'periodic' => 1, 'purpose' => "???",
            'index' => 0, 'required_to_fill' => 1, 'show_in_default_list_form' => 1, 'system' => 1,'relations' => 'Имя существующей таблицы'],*/

         'type' => ['notion' => 'Type', 'description' => 'Статус объекта(1 - актуальный, 2 - не актуальный, 3 - удалить)', 'type' => 'enum', 'default' => '1', 'periodic' => 1, 'purpose' => "???",
            'index' => 1, 'required_to_fill' => 1, 'show_in_default_list_form' => 1, 'system' => 0,'relations' => 'Имя существующей таблицы', 'enum' => 'AddressTypes'],
        ];
        
        if (!$this::withGroups)
            $columns['parent']['hide'] = 1;
        
        return $columns;
    }
}
