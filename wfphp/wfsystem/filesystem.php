<?php

/**
 * filesystem
 *
 * @author Jiaheng.Wu <gufei005@163.com>
 */
class Wfsystem_Filesystem {
    
    
    public static function isemptydir($dir){
        
        if($handle = opendir($dir)){
            while(($file = readdir($handle)) !== false){
                if($file!="." or $file!=".."){
                    closedir($handle);
                    return false;
                }
            }
            closedir($handle);
            return true;
        }else{
            return false;
        }
        
    }
    
    public static function deletedir($dir){
        
        $d = dir($dir);
        while( false !== ($entry = $d->read()) ) {
            if($entry == '.' || $entry == '..') continue;
            $currele = $d->path.'/'.$entry;
            if(is_dir($currele)){
                if(self::isemptydir($currele)){
                    rmdir($currele);
                }else{
                    self::deletedir($currele);
                }
            }
            else unlink($currele);
        }
        $d->close();

        rmdir($dir);
        return true;
    }
}

?>
