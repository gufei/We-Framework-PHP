<?php

/**
 * common
 * 
 * @author Jiaheng.Wu <gufei005@163.com>
 */


//类的自动加载
spl_autoload_register('__autoload');

/**
 * 自动加载
 * @param type $classname
 */
function __autoload($classname){
    //echo $classname;
    require_once __DIR__.'/config.php';
    if( ! ($file_path = Wfsystem_Config::get("autoload.".$classname))){
        if(strtolower(substr($classname,0,2))=="wf"){
            $file_path = WF_SYS_PATH.str_replace("_",DIRECTORY_SEPARATOR,strtolower($classname)).".php";
        }else{
            $file_path = WF_APP_PATH.str_replace("_",DIRECTORY_SEPARATOR,strtolower($classname)).".php";
        }
    }
    
    //var_dump($file_path);
    
    if(file_exists($file_path)){
        require_once $file_path;
    }
    else{
        
        
    }
    
}


Wfsystem_Wfphp::init();








?>
