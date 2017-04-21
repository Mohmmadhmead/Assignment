<?php
namespace console\controllers;

class TestController extends \yii\console\Controller
{

    public function actionIndex()
    {
\Yii::$app
    ->db
    ->createCommand()
    ->delete('post',"date<=CURDATE()-3")
    ->execute();
    }
}