<?php
/**
 * Created by PhpStorm.
 * User: 201709290001
 * Date: 2018/10/22 0022
 * Time: 18:59
 */
namespace sf\cache;
class FileCache implements \sf\cache\CacheInterface
{
    public $cachePath;

    public function buildkey($key)
    {
        // TODO: Implement buildkey() method.
        if (!is_string($key)) {
            $key = json_encode($key);
        }
        return md5($key);
    }

    public function get($key)
    {
        // TODO: Implement get() method.
        $key = $this->buildkey($key);
        $cacheFile = $this->cachePath . $key;
        if(@filemtime($cacheFile)>time()){
            return unserialize(@file_get_contents($cacheFile));
        }else{
            return false;
        }
    }

    public function exists($key)
    {
        // TODO: Implement exists() method.
        $key = $this->buildkey($key);
        $cacheFile = $this->cachePath.$key;
        return @filemtime($cacheFile)>time();
    }

    public function mget($keys)
    {
        // TODO: Implement mget() method.
        $results = [];
        foreach ($keys as $key) {
            $results[$key] = $this->get($key);
        }
        return $results;
    }

    public function set($key, $value, $duration = 0)
    {
        // TODO: Implement set() method.
        $key = $this->buildkey($key);
        $cacheFile = $this->cachePath .$key;
        $value = serialize($value);
        if(file_put_contents($cacheFile,$value,LOCK_EX) !== false){
            if($duration <=0) {
                $duration =31536000;
            }
            return touch($cacheFile,$duration + time());
        }else{
            return false;
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
        // TODO: Implement mad() method.
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
        $key = $this->buildkey($key);
        $cacheFile = $this->cachePath.$key;
        return unlink($cacheFile);
    }

    public function flush()
    {
        // TODO: Implement flush() method.
        $dir = @dir($this->cachePath);

        while (($file = $dir->read()) !== false){
            if($file !== '.' && $file !== '..'){
                unlink($this->cachePath.$file);
            }
        }
        $dir->close();
    }

}