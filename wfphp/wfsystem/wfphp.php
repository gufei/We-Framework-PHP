<?php

/**
 * wfphp
 *
 * @author Jiaheng.Wu <gufei005@163.com>
 */
class Wfsystem_Wfphp {
    static public function init(){
        //加载配置文件
        Wfsystem_Config::load();
        //加载系统函数
        Wfsystem_Function::load();
        
        //处理参数
        Wfsystem_Request::init();
        
        //控制器路由
        Wfsystem_Route::singleton()->route();
        
        
    }
}

?>
