<?php
/**
 * Created by PhpStorm.
 * User: 201709290001
 * Date: 2018/10/22 0022
 * Time: 16:10
 */
namespace  app\models;
use sf\db\Model;

class User extends Model
{
    public static function tablename()
    {
        return 'user';
    }
}