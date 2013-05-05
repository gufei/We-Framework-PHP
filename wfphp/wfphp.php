<?php

/**
 * wfphp入口文件
 * 
 * @author Jiaheng.Wu <gufei005@163.com>
 */

//var_dump($_SERVER);


// 系统目录定义
defined('WF_SYS_PATH') or define('WF_SYS_PATH', dirname(__FILE__).'/');
// 系统基础目录
defined('WF_SYS_SYSTEM_PATH') or define('WF_SYS_SYSTEM_PATH',WF_SYS_PATH.'wfsystem/');

// 当前项目目录定义
defined('WF_APP_PATH') or define('WF_APP_PATH', dirname($_SERVER['SCRIPT_FILENAME']).'/');
// 当前项目名称
defined('WF_APP_NAME') or define('WF_APP_NAME', basename(dirname($_SERVER['SCRIPT_FILENAME'])));


// 系统第三方类库目录
defined('WF_SYS_VENDOR_PATH') or define('WF_SYS_VENDOR_PATH',WF_SYS_PATH.'wfvendor/');

// error_reporting(E_ALL | E_STRICT);

// 为了方便导入第三方类库 设置vendor目录到include_path
set_include_path(get_include_path() . PATH_SEPARATOR . WF_SYS_VENDOR_PATH);


// 系统配置目录
defined('WF_SYS_CONF_PATH') or define('WF_SYS_CONF_PATH',WF_SYS_PATH.'wfconf/');
// 系统函数目录
defined('WF_SYS_FUNCTION_PATH') or define('WF_SYS_FUNCTION_PATH',WF_SYS_PATH.'wffunction/');
// 系统控制器目录
defined('WF_SYS_CONTROLLER_PATH') or define('WF_SYS_CONTROLLER_PATH',WF_SYS_PATH.'wfcontroller/');
// 系统模型目录
defined('WF_SYS_MODELS_PATH') or define('WF_SYS_MODELS_PATH',WF_SYS_PATH.'wfmodels/');


date_default_timezone_set('Asia/Shanghai');

// 是否开启了魔术引号
if(version_compare(PHP_VERSION,'5.4.0','<')) {
    ini_set('magic_quotes_runtime',0);
    define('MAGIC_QUOTES_GPC',get_magic_quotes_gpc()?True:False);
}else{
    define('MAGIC_QUOTES_GPC',false);
}


require_once WF_SYS_SYSTEM_PATH.'common.php';

?>
