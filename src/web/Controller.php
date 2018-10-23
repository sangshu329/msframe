<?php
/**
 * Created by PhpStorm.
 * User: 201709290001
 * Date: 2018/10/22 0022
 * Time: 13:46
 */
namespace sf\web;
class Controller extends \sf\base\Controller
{
    public function render($view, $params = [])
    {
        extract($params);
        return require '../views/'.$view.'.php';
    }


}