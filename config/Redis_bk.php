<?php
/**
 * Created by PhpStorm.
 * User: 201709290001
 * Date: 2018/10/22 0022
 * Time: 20:22
 */
return [
    'class'=>'sf\cache\RedisCache',
    'redis'=>[
        'host'=>'127.0.0.1',
        'port'=>6379,
        'database'=>0,
        'password' =>'foobared',
        // 'options' => [Redis::OPT_SERIALIZER, Redis::SERIALIZER_PHP],
    ]
];

