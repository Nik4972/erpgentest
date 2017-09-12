<?php
namespace backend;

trait ErpGroupModel
{
    public function delete()
    {
        $connection = $this->getDb();
        $ids = [$this->id];
        do {
            $found = false;
            $command = $connection->createCommand('SELECT `id` FROM `'.$this->tableName().'` WHERE `group_id`='.$this->id.' AND `is_group`=1');
            $groups = $command->queryAll();
            $found = count($groups);
            foreach ($groups as $row)
                $ids[] = $row['id'];
        } while ($found);
        $ids = implode(',', $ids);
        return $connection->createCommand('UPDATE `'.$this->tableName().'` SET `status` = 3 WHERE `group_id` IN ('.$ids.') OR `id` IN ('.$ids.')')->execute();
    }

    public function getGroups($prefix = '--')
    {
        $groups = [];
        $index = [];
       

        $connection = $this->getDb();
        
        $ids = false;
        $level = '';
        do {
            $rows = $connection->createCommand('SELECT `id`, `title`, `group_id` FROM `'.$this->tableName().'` WHERE `group_id` '
                .($ids ? 'IN ('.implode(',', $ids).')' : 'IS NULL').' AND `is_group`=1 AND `status`=1')->queryAll();
            $ids = [];
            foreach ($rows as $row) {
                $ids[] = $row['id'];
                
                if (!isset($index[$row['group_id']])) {
                    $groups[$row['id']] = $level.$row['title'];
                    $groups['rows'.$row['id']] = [];
                    $index[$row['id']] = &$groups['rows'.$row['id']];
                } else {
                    $index[$row['group_id']][$row['id']] = $level.$row['title'];
                    $index[$row['group_id']]['rows'.$row['id']] = [];
                    $index[$row['id']] = &$index[$row['group_id']]['rows'.$row['id']];
                }
            }
            $level .= $prefix;
        } while ($ids);
        
        $this->_groups = [];
        array_walk_recursive($groups, array($this, 'prepareGroups'));
        
        return $this->_groups;
    }
    
    protected $_groups;
    protected function prepareGroups($item, $key)
    {
        $this->_groups[$key] = $item;
    }
}