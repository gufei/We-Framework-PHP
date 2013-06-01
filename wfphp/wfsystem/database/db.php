<?php

/**
 * db
 *
 * @author Jiaheng.Wu <gufei005@163.com>
 */
class DB {
    
    public static function select($param = NULL){
        return new Wfsystem_Database_Sys_Select(func_get_args());
    }
}

?>
