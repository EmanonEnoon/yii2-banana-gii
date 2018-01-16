<?php

namespace osenyursa\banana\controllers;

use Yii;
use yii\console\Controller;
use yii\helpers\Inflector;

class BananaController extends Controller
{
    public $table;

    public $ns = 'app\models\gii';

    public function actionModel()
    {
        if ($this->table) {
            $tables[] = $this->table;
        } else {
            $tables = Yii::$app->db->createCommand('SHOW TABLES')->queryAll();
            array_walk($tables, function(&$element){
                $element = reset($element);
            });
        }

        foreach ($tables as $table){
            Yii::$app->runAction('gii/model', [
                'interactive' => false,
                'tableName' => $table,
                'modelClass' => Inflector::camelize($table),
                'ns' => $this->ns,
                'generateLabelsFromComments' => true,
                'useTablePrefix' => true,
                'enableI18N' => true,
            ]);

            $ns = substr($this->ns,0,-4);

        }
    }
}