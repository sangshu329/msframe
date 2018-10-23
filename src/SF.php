<?php
/**
 * Created by PhpStorm.
 * User: 201709290001
 * Date: 2018/10/22 0022
 * Time: 18:38
 */
class SF
{
    public static function createObject($name)
    {
        $config = require(SF_PATH."/config/$name.php");
        $instance = new $config['class']();
        unset($config['class']);
        foreach ($config as $key => $value) {
            $instance->$key=$value;
        }
        if($instance instanceof sf\base\Component){
            $instance->init();
        }
        return $instance;
    }
}