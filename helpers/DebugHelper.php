<?php

namespace app\helpers;

use Yii;
use yii\helpers\VarDumper;

/**
 * ContactForm is the model behind the contact form.
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