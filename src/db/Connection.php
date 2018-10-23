<?php
/**
 * Created by PhpStorm.
 * User: 201709290001
 * Date: 2018/10/22 0022
 * Time: 18:43
 */

namespace sf\db;
use PDO;

class Connection
{
    public $dsn;
    public $username;
    public $password;

    public $attributes;

    public function getDb()
    {
        return new PDO($this->dsn,$this->username,$this->password,$this->attributes);
    }
}