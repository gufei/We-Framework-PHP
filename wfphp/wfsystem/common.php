<?php

/**
 * common
 * 
 * @author Jiaheng.Wu <gufei005@163.com>
 */

require_once WF_SYS_SYSTEM_PATH . "autoload.php";
//类的自动加载
$classLoader = new Wfsystem_Autoload();
$classLoader->register();



Wfsystem_Wfphp::init();








?>
