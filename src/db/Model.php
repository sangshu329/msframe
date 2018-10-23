<?php
/**
 * Created by PhpStorm.
 * User: 201709290001
 * Date: 2018/10/22 0022
 * Time: 14:09
 */

namespace sf\db;

use PDO;
use SF;

class Model implements ModelInterfase
{

    public static $pdo;

    public static function getDb()
    {
        if (empty(static::$pdo)) {
            $config = require(SF_PATH . '/config/db.php');
//            static::$pdo = new $config['class']($config['dsn'], $config['username'], $config['password']);
            static::$pdo = SF::createObject('db')->getDb();
            static::$pdo->exec("set names 'utf8'");
        }

        return static::$pdo;
    }

    public static function tablename()
    {
        // TODO: Implement tablename() method.
        return get_called_class();
    }

    public static function primaryKey()
    {
        // TODO: Implement primaryKey() method.
        return ['id'];
    }

    public static function findOne($condition = null)
    {
        list($where, $params) = static::buildWhere($condition);
        $sql = 'select * from ' . static::tablename() . $where;
        $stmt = static::getDb()->prepare($sql);
        $rs = $stmt->execute($params);
        $models = [];

        if ($rs) {
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            if (!empty($row)) {
                return static::arr2Model($row);
            }
        }
        return null;
    }

    public static function findAll($condition)
    {
        // TODO: Implement findAll() method.
        list($where, $params) = static::buildWhere($condition);
        $sql = 'select * from ' . static::tablename() . $where;
        $stmt = static::getDb()->prepare($sql);
        $rs = $stmt->execute($params);
        $models = [];

        if ($rs) {
            $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
            foreach ($rows as $row) {
                if (!empty($row)) {
                    $model = static::arr2Model($row);
                    array_push($models, $model);
                }
            }
        }
        return $models;
    }

    public static function buildWhere($condition, $params = null)
    {
        if (is_null($params)) {
            $params = [];
        }
        $where = '';
        if (!empty($condition)) {
            $where .= ' where ';
            $keys = [];
            foreach ($condition as $key => $value) {
                array_push($keys, "$key = ?");
                array_push($params, $value);
            }
            $where .= implode(' and ', $keys);
        }
        return [$where, $params];
    }

    public static function arr2Model($row)
    {
        $model = new static();
        foreach ($row as $rowKey => $rowValue) {
            $model->$rowKey = $rowValue;
        }
        return $model;
    }

    public static function updateAll($condition, $attributes)
    {
        // TODO: Implement updateAll() method.
        $sql = ' update ' . static::tablename();
        $params = [];

        if (!empty($attributes)) {
            $sql = ' set ';
            $params = array_values($attributes);
            $keys = [];
            foreach ($attributes as $key => $value) {
                array_push($keys, "$key=?");
            }
        }

        list($where, $params) = static::buildWhere($condition, $params);
        $sql .= $where;

        $stmt = static::getDb()->prepare($sql);
        $execResult = $stmt->execute($params);
        if ($execResult) {
            $execResult = $stmt->rowCount();
        }
        return $execResult;
    }

    public static function deleteAll($condition)
    {
        // TODO: Implement deleteAll() method.
        list($where, $params) = static::buildWhere($condition);
        $sql = ' delete from ' . static::tablename() . $where;

        $stmt = static::getDb()->prepare(sql);
        $execResult = $stmt->execute($params);
        if ($execResult) {
            $execResult = $stmt->rowCount();
        }
        return $execResult;
    }

    public function insert()
    {
        // TODO: Implement insert() method.
        $sql = 'insert into ' . static::tablename();
        $params = [];
        $keys = [];
        foreach ($this as $key => $value) {
            array_push($keys, $key);
            array_push($params, $value);
        }
        $holders = array_fill(0, count(keys), '?');
        $sql = ' (' . implode(' , ', $keys) . ') values (' . implode(' , ', $holders) . ')';

        $stmt = static::getDb()->prepare($sql);
        $execResult = $stmt->execute($params);

        $primaryKeys = static::primaryKey();
        foreach ($primaryKeys as $name) {
            $lastId = static::getDb()->lastInsertId($name);
            $this->$name = (int)$lastId;
        }
        return $execResult;
    }

    public function update()
    {
        // TODO: Implement update() method.
        $primaryKes = static::primaryKey();
        $condition = [];
        foreach ($primaryKes as $name) {
            $condition[$name] = isset($this->$name) ? $this->$name : null;
        }

        $attributes = [];
        foreach ($this as $key => $value) {
            if (!in_array($key, $primaryKes, true)) {
                $attributes[$key] = $value;
            }
        }
        return static::updateAll($condition, $attributes) !== false;
    }

    public function delete()
    {
        // TODO: Implement delete() method.
        $primaryKeys = static::primaryKey();
        $condition = [];
        foreach ($primaryKeys as $name) {
            $condition[$name] = isset($this->$name) ? $this->$name : null;
        }

        return static::deleteAll($condition) !== false;
    }


}