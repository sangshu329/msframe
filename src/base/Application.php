<?php
/**
 * Created by PhpStorm.
 * User: 201709290001
 * Date: 2018/10/22 0022
 * Time: 13:33
 */
namespace sf\base;
use Exception;

abstract class Application{
    public $controllerName = 'app\\controllers';

    public function run()
    {
        try{
            return $this->handleRequest();
        }catch (Exception $e){
            return $e;
        }
    }

    abstract public function handleRequest();

}