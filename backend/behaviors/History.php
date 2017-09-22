<?php
// Разместить в namespace
namespace backend\behaviors;

use yii;
use yii\base\Behavior;

class History extends Behavior
{
    public $iniciali = null;

    public function events()
    {    
            return [    
                //yii\web\Controller:: EVENT_AFTER_INSERT => 'getCreate',  
                //yii\web\Controller::EVENT_AFTER_UPDATE => 'getUpdate',  
            ];
    }    
    
    public function getCreate(){
           ;    
    }
     public function getUpdate(){
          $values = $this->owner->getDirtyAttributes(); // Измененные атрибуты
             
    }
}
