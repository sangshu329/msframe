<?php
/**
 * Created by PhpStorm.
 * User: 201709290001
 * Date: 2018/10/22 0022
 * Time: 13:36
 */
namespace sf\web;
class Application extends \sf\base\Application
{
    public function handleRequest()
    {
        // TODO: Implement handleRequest() method.
        $router = $_GET['r'];
        list($controllerName,$actionName) = explode('/',$router);
        $ucController = ucfirst($controllerName);
        $controllerNameAll = 'app\\controllers\\'.$ucController.'Controller';
        $controller = new $controllerNameAll();
        $controller->id=$controllerName;
        $controller->action=$actionName;
        return call_user_func([$controller,'action'.ucfirst($actionName)]);
    }

}