<?php

/**
 * function
 *
 * @author Jiaheng.Wu <gufei005@163.com>
 */
class Wfsystem_Function {
    static public function load(){
        foreach(glob(WF_SYS_FUNCTION_PATH."*.php") as $file_name){
            require_once $file_name;
        }
    }
}
?>
