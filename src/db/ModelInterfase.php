<?php
/**
 * Created by PhpStorm.
 * User: 201709290001
 * Date: 2018/10/22 0022
 * Time: 14:05
 */

namespace sf\db;

interface ModelInterfase
{
    public static function tablename();

    public static function primaryKey();

    public static function findOne($condition);

    public static function findAll($condition);

    public static function updateAll($condition, $attributes);

    public static function deleteAll($condition);

    public function insert();

    public function update();

    public function delete();

}