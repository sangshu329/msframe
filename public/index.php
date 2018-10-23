<?php
/**
 * Created by PhpStorm.
 * User: 201709290001
 * Date: 2018/10/22 0022
 * Time: 11:53
 */
define('SF_PATH',dirname(__DIR__));
require  __DIR__.'/../vendor/autoload.php';
require (SF_PATH.'/src/SF.php');


$application = new sf\web\Application();
$application->run();

