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
 
            Yii::$app->db->createCommand("CREATE TABLE IF NOT EXISTS " . $table . " (" . $common_fields .
                    " PRIMARY KEY (`id`)) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci")->execute();
        }

// Add to tables specific columns and foreign key
 
        foreach ($tables as $table) {

            $tab = Yii::$app->db->createCommand("SELECT * FROM _all_tables WHERE id='".$table."'")
               ->queryAll();

            $columns = Yii::$app->db->createCommand("SELECT * FROM _all_columns WHERE table_id='" . $table . "'")
                    ->queryAll();

            if ($columns) {
                foreach ($columns as $column) {

                    if (strripos($column['type'], '.')) {
                        $fk = stristr($column['type'], '.', true);

                        $sql = Yii::$app->db->createCommand("ALTER TABLE " . $table . " ADD " . $column['id'] . " int(10)")
                                ->execute();

                        $sql = Yii::$app->db->createCommand("ALTER TABLE " . $table .
                                        " ADD CONSTRAINT  FOREIGN KEY (" . $column['id'] . ") REFERENCES " . $fk . " (id) ON UPDATE CASCADE ON DELETE RESTRICT")
                                ->execute();
                    } else {
                        $sql = Yii::$app->db->createCommand("ALTER TABLE " . $table . " ADD " . $column['id'] . " " . $column['type'])
                                ->execute();
                    }
                }
            }

// Create name_tables array
            $columns = Yii::$app->db->createCommand("SHOW COLUMNS FROM " . $table)
                    ->queryAll();

            $columns_list = array();

            foreach ($columns as $column) {
                $columns_list[$column['Field']] = $column_parameter;
            }


            $name_tables = $table;
            $name_tables = array(
                'table'       => $tab[0]['id'],
                'notion'      => $tab[0]['notion'],
                'description' => $tab[0]['description'],
                'hierarchy'   => $tab[0]['hierarchy'],
                'module'      => $tab[0]['module'],
                'type'        => $tab[0]['type'],
                'columns'     => $columns_list
            );

            $templateView = new View();
            $templates    = [
                //'test.php' => 'models/%s.php',
                //'test2.php' => 'controllers/%sController.php'
                'controller.php' => 'controllers/%sController.php',
                'model.php' => 'models/%s.php',
                'modelsearch.php' => 'models/%sSearch.php',
            ];
            
            $templates    = []; // comment or remove this line to generate real files from "generatortemplates" directory

            $templatesDirs = ['models', 'controllers'];
            $moduleDir     = Yii::getAlias('@app') . '/modules/' . ($name_tables['module'] ? $name_tables['module'] : 'core') . '/';
            foreach ($templatesDirs as $subdir) {
                @mkdir($moduleDir . $subdir, 0777, true);
            }
            foreach ($templates as $viewName => $savePath) {
                $fileContent  = $templateView->renderPhpFile(Yii::getAlias('@app') . '/generatortemplates/' . $viewName, ['name_tables' => $name_tables]);
                $saveFileName = Yii::getAlias('@app') . '/modules/'
                        . ($name_tables['module'] ? $name_tables['module'] : 'core')
                        . '/' . sprintf($savePath, ucfirst($name_tables['notion']));

                file_put_contents($saveFileName, $fileContent);
            }
        }  // End of processing all tables
        
        \backend\ErpForm::saveMenu($tables);

        return $tables;

    }
}