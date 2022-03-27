<?php

namespace app\helpers;

use Yii;
use yii\helpers\VarDumper;

/**
 * Yii::$app->debugger->dd(); - вызов
 */
class DebugHelper 
{
    public static function dd($var)
    {
        ob_clean(); 
        VarDumper::dump($var, 10, true);
        exit;
    }

}