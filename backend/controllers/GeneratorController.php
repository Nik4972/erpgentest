<?php

namespace backend\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\web\Controller;
use yii\base\View;

use backend\ErpGenerator;

class GeneratorController extends Controller {

    /**
     * Create tables.
     *
     * @return string
     */
    public function actionGenerator() {

       $tables = Yii::$app->db->createCommand('SELECT * FROM _all_tables')
                ->queryAll();
 
       return $this->render('generator', [
          'tables' => $tables,
         ]);

    }

    public function actionGenerator2() {
     
     $list_tables=$_POST['list_tables'];

     $result =ErpGenerator::generate($list_tables);

     return $this->render('generator2', [
          'tables' => $result,
         ]);

    }

    public function actionDrop() {
     
     $result =\backend\ErpForm::clearMenu();

     return $this->render('droped', [
          'tables' => $result,
         ]);

    }
    
    public function actionSend_email() {

     $to = 'user@mail.com';

     $message = Yii::$app->mailer->compose()
    ->setFrom('from@domain.com')
    ->setTo($to)
    ->setSubject('Message subject')
    ->setTextBody('Plain text content')
    ->attach('/home/nik/ssh.txt')
    ->send();

     return $this->render('send_email', [
          'message' => $to
         ]);

    }
    


}
