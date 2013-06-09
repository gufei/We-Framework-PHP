<?php

/**
 * db
 *
 * @author Jiaheng.Wu <gufei005@163.com>
 */
class Wfsystem_Db {
    
    public static function query($type, $sql)
	{
		return new Wfsystem_Db_Query($type, $sql);
	}
    
    
    
}

?>
