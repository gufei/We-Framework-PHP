<?php

/**
 * config
 *
 * @author Jiaheng.Wu <gufei005@163.com>
 */
class Wfsystem_Config {
    
    /**
     * 重新载入配置文件
     */
    public static function load(){
        $GLOBALS['WF_CONFIG'] = array();
        foreach(glob(WF_SYS_CONF_PATH."*.php") as $conf_file_name){
            if(file_exists($conf_file_name)){
                $GLOBALS['WF_CONFIG'] = array_merge($GLOBALS['WF_CONFIG'], include_once $conf_file_name);
            }
        }
    }
    /**
     * 读取配置
     * @param string $name
     * @param array $fromdata
     * @return type
     */
    public static function get($name=null,array $fromdata=null){
        if(empty($name)){
            return $GLOBALS['WF_CONFIG'];
        }
        if(empty($fromdata)){
            $fromdata = isset($GLOBALS['WF_CONFIG']) ? $GLOBALS['WF_CONFIG'] : array();
        }
        if(strpos($name,".")!==false){
            $key = substr($name,0,strpos($name,"."));
            $name = substr($name,strpos($name,".")+1);
            if(isset($fromdata[$key])){
                return self::get($name,$fromdata[$key]);
            }
            
        }else{
            if(isset($fromdata[$name])){
                return $fromdata[$name];
            }
            
        }
        return false;
        
    }
}

?>
