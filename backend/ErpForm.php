<?php
namespace backend;
use Yii;

/**
 * Manage form filters and columns
 */
class ErpForm extends \yii\db\ActiveRecord
{
    public static function tableName()
    {
        return '_form_data';
    }
    public function rules()
    {
        return [
            [['title', 'form', 'type', 'data'], 'safe'],
        ];
    }
    
    /**
     * @return ErpForm object
     */
    public static function getFormConfig($model, $type)
    {
        $form = self::find()->where(['=', '`type`', $type])
            ->andWhere(['=', '`form`', $model::tableName()])->one();
        return $form;
    }
    
    /**
     * @return ordered array of columns with visibility flag. Exapmple ['notion' => true, 'id' => false]
     */
    public static function getColumns($model)
    {
        $form = self::getFormConfig($model, 'columns');
        if ($form) {
            $columns = json_decode($form->data);
        }
        else {
            $columns = [];
            foreach ($model->getColumns() as $col_name => $col_defs) {
                if (!isset($col_defs['hide']) || !$col_defs['hide'])
                    $columns[$col_name] = $col_defs['show_in_default_list_form'];
            }
        }
        return $columns;
    }
    
    /**
     * @return filter by column type (or name).
     */
    public static function getColumnFilter($column_id, $column, $model)
    {
        if ($column_id == 'xnotion' || $column_id == 'code') { // input[text] will be displayed
            return true;
        }
        if ($column_id == 'status') { // REMOVE: temporally solution, later will be replaced with toolbar button dialog, not filter
            return false; //[1=>'actual','archive','deleted',4=>'all'];
        }

        if ($column['type'] == 'enum') { // list of predefied values
            $filter = [];
            foreach (\backend\ErpEnums::$$column['enum'] as $str) {
                $filter[$str] = $str;
            }
            return $filter;
        }

        switch ($column['type']) {
            case 'varchar':
            case 'text':
                $filter = $model->getFilterValues($column_id); // ask model for a list of distinct values from this column
                return $filter;
                break;
            case '':
            case '':
            case '':
                return true;
            default:
                return true;
        }
    }
    
    /**
     * Save columns (visibility and order) configuration for the list form of model
     */
    public static function saveColumns($model)
    {
        $modelColumns = $model->getColumns();
        
        $data = ['title' => 'columns', 'type' => 'columns', 'form' => $model::tableName()];
        $columns = $_POST['columns'];
        foreach ($columns as $col_name => $col_val) {
            if (!isset($modelColumns[$col_name]) || (isset($modelColumns[$col_name]['hide']) && $modelColumns[$col_name]['hide'])) // never visible colum checking
                unset($modelColumns[$col_name]);
            elseif (isset($modelColumns[$col_name]['always_visible']) && $modelColumns[$col_name]['always_visible']) // column is always wisible
                $columns[$col_name] = $col_name;
            elseif ($col_val != $col_name) // column marked as invisible in list form
                $columns[$col_name] = '';
        }
        $data['data'] = json_encode($columns);

        $formData = ErpForm::getFormConfig($model, 'columns');
        if (!$formData)
            $formData = new ErpForm();

        $formData->attributes = $data;
        $formData->save();
    }
    
    

    /**
     * @return filter by column type (or name).
     */
    public static function getColumnValue($column_id, $column, $view)
    {
        if ($column_id == 'notion') { // input[text] will be displayed
            return function($data) use($view) {return $data->group ? 
                '<a href="'.\yii\helpers\Url::current([$view->params['searchModel'] => ['parent' => $data->id, 'group' => 1]]).'">'.$data->notion.'</a>' 
                : $data->notion;
                };
        }

        return false;
    }
    
    
    
    public static function getMenu() // REMOVE: quick solution to view generated tables under left menu
    {
        $menu = @include('menu_local.php');
        if (!$menu)
            $menu = [];
        return $menu;
    }
    
    public static function saveMenu($tables) // REMOVE: quick solution to view generated tables under left menu
    {
        $templateView = new yii\base\View();
        $fileContent  = $templateView->renderPhpFile(Yii::getAlias('@app') . '/generatortemplates/menu.php', ['tables' => $tables]);
        $saveFileName = __DIR__.'/menu_local.php';
        file_put_contents($saveFileName, $fileContent);
    }

    public static function clearMenu() // REMOVE: quick solution to view generated tables under left menu
    {
        $tables = ['banks', 'counterparties', 'regions_name', 'regions', 'countries', 'macroregions_geo', 'macroregions_kom'];
        foreach ($tables as $table) {
            Yii::$app->db->createCommand("DROP TABLE IF EXISTS " . $table )->execute();
        }
        ErpForm::saveMenu([]);
        return $tables;
    }

    
}