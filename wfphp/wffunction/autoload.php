<?php

/**
 * autoload
 * 
 * @author Jiaheng.Wu <gufei005@163.com>
 */

/**
 * 加载配置文件
 */
function wf_load_conf(){
    //加载配置文件
    if( ! (isset($GLOBALS['WF_CONFIG']))){
        System_Config::load();
    }
}

function wf_load_controller($controller=null,$action=null){
    if(empty($controller)){
        $controller = "empty";
    }
    if(empty($action)){
        $action = "default";
    }
}
function test(){
    echo "ccc";
}
?>
