<?php
/**
 * Created by PhpStorm.
 * User: 201709290001
 * Date: 2018/10/22 0022
 * Time: 20:21
 */
namespace sf\cache;
class RedisCache extends \sf\base\Component implements \sf\cache\CacheInterface
{
    public $redis;

    public function init()
    {
        if(is_array($this->redis)){
            extract($this->redis);
//            $redis = new \Redis();
//            $redis->connect($host,$port);
            \Predis\Autoloader::register();
            $redis = new \Predis\Client(['scheme'=>'tcp','host'=>$host,'port'=>$port]);
            if(!empty($password)){
//                $redis = new \Predis\Client(['scheme'=>'tcp','host'=>$host,'port'=>$port,'password'=>$password]);
                $redis->auth($password);
            }
            $redis->select($database);

            if(!empty($options)){
                call_user_func_array([$redis,'setOption'],$options);
            }
            $this->redis = $redis;
        }
        if(!$this->redis instanceof \Predis\Client){
            throw new \Exception('Cache::redis must be either a Redis connection instance.');
        }
    }

    public function buildkey($key)
    {
        // TODO: Implement buildkey() method.
        if(!is_string($key)){
            $key = json_encode($key);
        }
        return md5($key);
    }

    public function get($key)
    {
        // TODO: Implement get() method.
        $key  = $this->buildkey($key);
        return $this->redis->get($key);
    }

    public function exists($key)
    {
        // TODO: Implement exists() method.
        $key = $this->buildkey($key);
        return $this->redis->exists($key);
    }

    public function mget($keys)
    {
        // TODO: Implement mget() method.
        for ($index = 0; $index<count($keys);$index++){
            $keys[$index] = $this->buildkey($keys[$index]);
        }
        return $this->redis->mGet($keys);
    }

    public function set($key, $value, $duration = 0)
    {
        // TODO: Implement set() method.
        $key = $this->buildkey($key);
        if($duration !==0){
            $expire = (int) $duration * 1000;
            return $this->redis->set($key,$value,$expire);
        }else{
            return $this->redis->set($key,$value);
        }
    }

    public function mset($items, $duration = 0)
    {
        // TODO: Implement mset() method.
        $failedKeys = [];
        foreach ($items as $key => $value) {
            if($this->set($key,$value,$duration) === false){
                $failedKeys[] = $key;
            }
        }
        return $failedKeys;
    }


    public function add($key, $value, $duration = 0)
    {
        // TODO: Implement add() method.
        if(!$this->exists($key)){
            return $this->set($key,$value,$duration);
        }else{
            return false;
        }
    }

    public function madd($items, $duration = 0)
    {
        // TODO: Implement madd() method.
        $failedKeys = [];
        foreach ($items as $key => $value) {
            if($this->add($key,$value,$duration) === false){
                $failedKeys[] = $key;
            }
        }
        return $failedKeys;
    }

    public function delete($key)
    {
        // TODO: Implement delete() method.
        $key=$this->buildkey($key);
        return $this->redis->delete($key);
    }

    public function flush()
    {
        // TODO: Implement flush() method.
        return $this->redis->flushDb();
    }
}