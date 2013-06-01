<?php

/**
 * index
 *
 * @author Jiaheng.Wu <gufei005@163.com>
 */
class Controller_Index extends Wfsystem_Controller{
    public function __empty(){
        $this->assign("test","okok");
        $this->display('index.tpl');
    }
    
    public function test(){
        $value = "testccccc";
        Wfsystem_Cache::init()->set(__CLASS__."/".__FUNCTION__."/"."ccccc",$value);
        Wfsystem_Cache::init()->set("aaaaa",$value);
        
        var_dump(Wfsystem_Cache::init()->get("aaaaa"));
    }
    
    public function db(){
        $query = DB::select(array("username","un"),"password");
        $query->select("test");
        $query->from(array("test","t"));
        echo $query;
        exit;
    }
    
    public function log(){
        $log   = Wfsystem_Log::instance(dirname(__FILE__), 7)->logInfo("cccc");
        exit;
        $args1 = array('a' => array('b' => 'c'), 'd');
        $args2 = NULL;

        $log->logInfo('');
        $log->logNotice('Notice Test');
        $log->logWarn('Warn Test');
        $log->logError('Error Test');
        $log->logFatal('Fatal Test');
        $log->logAlert('Alert Test');
        $log->logCrit('Crit test');
        $log->logEmerg('Emerg Test');

        $log->logInfo('Testing passing an array or object', $args1,"ok");
        $log->logWarn('Testing passing a NULL value', $args2);

    }
    
   
}

?>
