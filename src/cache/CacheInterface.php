<?php
/**
 * Created by PhpStorm.
 * User: 201709290001
 * Date: 2018/10/22 0022
 * Time: 18:54
 */
namespace sf\cache;
interface CacheInterface
{
    public function buildkey($key);

    public function get($key);

    public function exists($key);

    public function mget($keys);

    public function set($key,$value,$duration=0);

    public function mset($items,$duration=0);

    public function add($key,$value,$duration=0);

    public function madd($items,$duration=0);

    public function delete($key);

    public function flush();

}