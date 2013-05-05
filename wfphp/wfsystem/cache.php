<?php

/**
 * cache
 *
 * @author Jiaheng.Wu <gufei005@163.com>
 */
class Wfsystem_Cache {
    
    public $cache;
    
    public $expire = 0;
    
    // 保存类实例在此属性中
    private static $instance;
    
    // 构造方法声明为private，防止直接创建对象
    private function __construct() {}
    
    public static function init() {
        if (!isset(self::$instance)) {
            self::$instance = new self();

            // 使用哪种方式的cache
            $cache_driver = "Wfsystem_Cache_".ucfirst(Wfsystem_Config::get("cache"));
            self::$instance->cache = new $cache_driver;
        }
        return self::$instance;
    }
    
    public function get($key) { return $this->cache->get($key); }
    
    public function set($key, $value, $expire=0) {
        
        if( $this->expire ) $expire=$this->expire;
        return $this->cache->set($key,$value,$expire);
    }
    
    public function delete($key) { return $this->cache->delete($key); }
    
    public function flush() { return $this->cache->flush(); }
}

?>
