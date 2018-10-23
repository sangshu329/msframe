<?php
/**
 * Created by PhpStorm.
 * User: 201709290001
 * Date: 2018/10/22 0022
 * Time: 17:53
 */

return [
    'class'=>'\sf\db\Connection',
    'dsn'=>'mysql:host=localhost;dbname=sf',
    'username'=>'root',
    'password'=>'root',
    'attributes'=>[
        \PDO::ATTR_EMULATE_PREPARES => false,
        \PDO::ATTR_STRINGIFY_FETCHES => false
    ]
];