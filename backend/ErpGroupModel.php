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