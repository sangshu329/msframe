<?php
/**
 * Created by PhpStorm.
 * User: 201709290001
 * Date: 2018/10/22 0022
 * Time: 11:58
 */
namespace app\controllers;

use app\models\User;

class SiteController extends \sf\web\Controller
{

    public function actionView()
    {
        $this->render('site/view',['body'=>'Test body information']);
    }

    public function actionTest()
    {
//        $user=User::findOne(['age'=>23]);
        $user=User::findOne();
        $data=[
            'first' => 'awesome-php-zh_CN',
            'second' => 'simple-framework',
            'user' => $user
        ];

        echo $this->toJson($data);
    }

    public function toJson($data)
    {
        if(is_string($data)){
            return $data;
        }
        return json_encode($data);
    }

    public function actionCache()
    {
        $cache = \SF::createObject('Redis');
        $cache->set('test','我就测试下');
        $result = $cache->get('test');
//        $cache->flush();
        echo $result;
    }

}