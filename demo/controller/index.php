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
        $db = new Wfsystem_Database_Mysql();
        $sql = "insert into member (`username`,`password`) values ('test','test')";
        $rs = $db->select("select * from member","object");
        var_dump($rs);
        
        $aa = $db->query($sql);
        var_dump($aa);
        exit;
    }
}

?>
