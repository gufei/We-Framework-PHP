<?php

/**
 * filecache
 *
 * @author Jiaheng.Wu <gufei005@163.com>
 */
class Wfsystem_Cache_Filecache {
    public function set($key, $value, $expire=0){
        if( $expire != 0){
            $expire = time() + (int) $expire;
        }else{
            $expire = time() * 2;
        }
        
        $value = "<?php exit();?>".PHP_EOL.$expire.PHP_EOL.serialize($value);
        
        $file = $this->getfile($key);
        return file_put_contents($file,$value);
        
    }
    
    public function get($key) {
        $file = $this->getfile($key);
        if( !file_exists($file)) return false;
        $string = file_get_contents($file);
        list($header,$expire,$value) = explode(PHP_EOL, $string,3);
        (int) $expire;
        if($expire != 0 && time() < $expire) {
            return unserialize($value);
        }else{
            return false;
        }
    }
    
    public function delete($key){
        return unlink($this->getfile($key));
    }
    
    public function flush(){
        $dir = Wfsystem_Config::get('filecache');
        Wfsystem_Filesystem::deletedir($dir);
        mkdir($dir,0777,true);
    }
    
    public function getfile($key){
        $cachebase = Wfsystem_Config::get('filecache');
        
        $cache = $cachebase.strtolower($key);
        
        $dir = dirname($cache);
        
        $file = basename($cache);
        
        if( ! is_dir($dir)) mkdir($dir,0777,true);
        return $file = $dir.DIRECTORY_SEPARATOR.md5($file).EXT;
    }
}

?>
