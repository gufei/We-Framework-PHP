<?php

/**
 * memcache
 *
 * @author Jiaheng.Wu <gufei005@163.com>
 */
class Wfsystem_Cache_Memcache {
    private $connection;
    
    /**
     * 
     */
    function __construct() {
        $this->connection = new MemCache;
        $config = Wfsystem_Config::get("memcache");
        foreach ($config as $v) {
                $this->addServer($v['host'],$v['port'],$v['weight']);
        }
    }
    
    
    /**
     * 添加memcache server
     * @param type $host
     * @param type $port
     * @param type $weight
     * @return boolean
     */
    function addServer($host, $port=11211, $weight=10) {
        return $this->connection->addServer($host,$port,true,$weight);
    }
    /**
     * 设置
     * @param type $key
     * @param type $data
     * @param type $expire
     * @return integer
     */
    function set($key,$data,$expire=0) {
        return $this->connection->set($key,$data,MEMCACHE_COMPRESSED,$expire);
    }
    /**
     * 读取
     * @param string $key
     * @return mixed
     */
    function get($key) {
        return $this->connection->get($key);
    }
    /**
     * 删除
     * @param string $key
     * @return boolean
     */
    function delete($key) {
        return $this->connection->delete($key);
    }
    /**
     * 刷新所有缓存
     * @return boolean
     */
    public function flush() {
        return $this->connection->flush();
    }
    
    function __destruct(){
        $this->connection->close();
    }
}

?>
