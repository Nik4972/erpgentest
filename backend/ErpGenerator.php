<?php

namespace backend;

use yii\base\View;
use Yii;

class ErpGenerator
{
    static function generate($tables)
    {

        $common_fields = "`id` int(10) NOT NULL AUTO_INCREMENT,
        `code` varchar(255),
        `notion` varchar(255),
        `description` varchar(255),
        `group` int(1),
        `parent` int(10),
        `predefined` int(1),
        `status` int(1),
        `date_create` int(20),
        `date_update` int(20),";

        $column_parameter = array(
            'notion'                    => '',
            'description'               => '',
            'type'                      => 'int',
            'default'                   => '',
            'periodic'                  => 0,
            'purpose'                   => "???",
            'index'                     => 1,
            'required_to_fill'          => 1,
            'show_in_default_list_form' => 0,
            'system'                    => 1
        );

// Create tables with default columns
 
        foreach ($tables as $table) {
 
 // create tables
           Yii::$app->db->createCommand("CREATE TABLE IF NOT EXISTS " . $table . " (" . $common_fields .
                  " PRIMARY KEY (`id`)) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci")->execute();
// end create tables 
        }

// Add to tables specific columns and foreign key
 
        $tables_all = [];
        foreach ($tables as $table) {

            $tab = Yii::$app->db->createCommand("SELECT * FROM _all_tables WHERE id='".$table."'")
               ->queryAll();

            $columns = Yii::$app->db->createCommand("SELECT * FROM _all_columns WHERE table_id='" . $table . "'")
                    ->queryAll();
// create tables columns
            if ($columns) {
                foreach ($columns as $col_id => $column) {

                    if (strripos($column['type'], '.id')) {
                        $fk = stristr($column['type'], '.', true);

                        $columns[$col_id]['relation'] = $fk;

                        $sql = Yii::$app->db->createCommand("ALTER TABLE " . $table . " ADD " . $column['id'] . " int(10)")
                                ->execute();

                        $sql = Yii::$app->db->createCommand("ALTER TABLE " . $table .
                                        " ADD CONSTRAINT  FOREIGN KEY (" . $column['id'] . ") REFERENCES " . $fk . " (id) ON UPDATE CASCADE ON DELETE RESTRICT")
                                ->execute();
                    } elseif (stripos($column['type'], 'enum.') === 0) {
                        $type = substr($column['type'], 5);
                        $columns[$col_id]['enum'] = $type;
                        $columns[$col_id]['type'] = 'enum';
                        $sql = Yii::$app->db->createCommand("ALTER TABLE " . $table . " ADD " . $column['id'] . " enum('" . implode("','", \backend\ErpEnums::$$type) ."')")
                                ->execute();
                    } else {
                        $sql = Yii::$app->db->createCommand("ALTER TABLE " . $table . " ADD " . $column['id'] . " " . $column['type'])
                                ->execute();
                    }
                }
            }
// end create tables columns
/*
*/

// Create name_tables array
            /*$columns = Yii::$app->db->createCommand("SHOW COLUMNS FROM " . $table)
                    ->queryAll();

            $columns_list = array();

            foreach ($columns as $column) {
                $columns_list[$column['Field']] = $column_parameter;
            }*/


            $common_columns = [
                'id' => ['notion' => 'ID', 'description' => '', 'type' => 'int', 'default' => '', 'periodic' => 0, 'purpose' => "both", 'index' => 1,
                    'required_to_fill' => 1, 'show_in_default_list_form' => 0, 'system' => 1, 'relation' => '', 'hide'=>1],
                'notion' => ['notion' => 'Notion', 'description' => '', 'type' => 'varchar(255)', 'default' => '', 'periodic' => 1, 'purpose' => "both",
                    'index' => 1, 'required_to_fill' => 1, 'show_in_default_list_form' => 1, 'system' => 0, 'relation' => '', 'always_visible'=>0],
                'code' => ['notion' => 'Code', 'description' => '', 'type' => 'varchar(255)', 'default' => '', 
                    'periodic' => 1, 'purpose' => "both",'index' => 1, 'required_to_fill' => 1, 'show_in_default_list_form' => 1, 
                    'system' => 0, 'relation' => '', 'always_visible'=>0],
                'description' => ['notion' => 'Description', 'description' => '', 'type' => 'varchar(255)', 'default' => '', 'periodic' => 0, 'purpose' => "group",
                    'index' => 0, 'required_to_fill' => 0, 'show_in_default_list_form' => 0, 'system' => 0, 'relation' => ''],
                'group' => ['notion' => 'Is Group', 'description' => '', 'type' => 'int', 'default' => '0', 'periodic' => 1, 'purpose' => "both",
                    'index' => 1, 'required_to_fill' => 1, 'show_in_default_list_form' => 0, 'system' => 0, 'relation' => '', 'hide'=>1],
                'parent' => ['notion' => 'Group', 'description' => '', 'type' => 'int', 'default' => '0', 'periodic' => 1, 'purpose' => "both",
                    'index' => 1, 'required_to_fill' => 0, 'show_in_default_list_form' => 1, 'system' => 0, 'relation' => ''],
                'predefined' => ['notion' => 'Predefined', 'description' => '', 'type' => 'int', 'default' => '0', 'periodic' => 1, 'purpose' => "both",
                    'index' => 1, 'required_to_fill' => 1, 'show_in_default_list_form' => 0, 'system' => 0, 'relation' => '', 'hide'=>1],
                 'status' => ['notion' => 'Status', 'description' => '', 'type' => 'int', 'default' => '1', 'periodic' => 1, 'purpose' => "both",
                    'index' => 1, 'required_to_fill' => 1, 'show_in_default_list_form' => 1, 'system' => 0,'relation' => '', 'hide'=>1],

                 'date_create' => ['notion' => 'Date Created', 'description' => '', 'type' => 'datetime', 'default' => 'now', 'periodic' => 1, 'purpose' => "both",
                    'index' => 0, 'required_to_fill' => 0, 'show_in_default_list_form' => 1, 'system' => 1,'relation' => '', 'hide'=>1],
                'date_update' => ['notion' => 'Date Updated', 'description' => '', 'type' => 'datetime', 'default' => 'now', 'periodic' => 1, 'purpose' => "both",
                    'index' => 0, 'required_to_fill' => 0, 'show_in_default_list_form' => 1, 'system' => 1,'relation' => '', 'hide'=>1],

            ];
            
            
            foreach ($columns as $row) {
                if (!isset($common_columns[$row['id']]))
                    $common_columns[$row['id']] = $row;
            }
            
            foreach ($common_columns as $id => $row) {
                if (!isset($common_columns[$id]['required_to_fill']))
                    $common_columns[$id]['required_to_fill'] = $row['required'];
                else
                    $common_columns[$id]['required'] = $row['required_to_fill'];

                if (!isset($common_columns[$id]['show_in_default_list_form']))
                    $common_columns[$id]['show_in_default_list_form'] = isset($row['show_def']) ? $row['show_def'] : 1;

                if (!isset($common_columns[$id]['relation'])) // fix it to real relational info
                    $common_columns[$id]['relation'] = '';
            }
            
            $common_columns['parent']['relation'] = $table;
            
            $col_code = $common_columns['code']; // move 'code' column to the end of columns list
            unset($common_columns['code']);
            $common_columns['code'] = $col_code; 

            $name_tables = $table;
            $name_tables = array(
                'name_tables' => $tab[0]['id'],
                'name'        => $tab[0]['id'],
                'notion'      => $tab[0]['notion'],
                'description' => $tab[0]['description'],
                'hierarchy'   => $tab[0]['hierarchy'],
                'module'      => $tab[0]['module'],
                'type'        => $tab[0]['type'],
                'columns'     => $common_columns /// !!!! another var
            );
            
            $tables_all[] = $name_tables;

            $templateView = new View();
            $templates    = [
                //'test.php' => 'models/%s.php',
                //'test2.php' => 'controllers/%sController.php'
                'controller.php' => 'controllers/%sController.php',
                'model.php' => 'models/%s.php',
                'modelsearch.php' => 'models/%sSearch.php',
            ];
            
            //$templates    = []; // comment or remove this line to generate real files from "generatortemplates" directory

            $templatesDirs = ['models', 'controllers'];
            $moduleDir     = Yii::getAlias('@app') . '/modules/' . ($name_tables['module'] ? $name_tables['module'] : 'core') . '/';
            foreach ($templatesDirs as $subdir) {
                @mkdir($moduleDir . sprintf($subdir, $name_tables['name']), 0777, true);
            }
            foreach ($templates as $viewName => $savePath) {
                $path = Yii::getAlias('@backend') . '/generatortemplates/' . $viewName;
                $fileContent  = $templateView->renderPhpFile($path, ['name_tables' => $name_tables]);
                $saveFileName = Yii::getAlias('@app') . '/modules/'
                        . ($name_tables['module'] ? $name_tables['module'] : 'core')
                        . '/' . sprintf($savePath, ucfirst($name_tables['name']));

                file_put_contents($saveFileName, $fileContent);
            }
        }  // End of processing all tables
        
        \backend\ErpForm::saveMenu($tables_all);

        return $tables;

    }
    
    public static function generateClassName($table_name, $module='')
    {
        if ($module)
            return '\backend\modules\\'.$module.'\models\\'.ucfirst($table_name);

        return ucfirst($table_name);
    }
    
    public static function generateClassRouter($table_name, $module='')
    {
        return $table_name;
        //return str_replace('_', '-', $table_name);
    }
    
}
