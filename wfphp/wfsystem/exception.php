<?php

/**
 * exception
 *
 * @author Jiaheng.Wu <gufei005@163.com>
 */
class Wfsystem_Exception extends Exception {
    
    public function __toString()
    {
        return Kohana_Exception::text($this);
    }
    
    public static function text(Exception $e)
    {
        return sprintf('%s [ %s ]: %s ~ %s [ %d ]',
                get_class($e),
                $e->getCode(),
                strip_tags($e->getMessage()),
                $e->getFile(),
                $e->getLine()
                );
    }
}

?>
