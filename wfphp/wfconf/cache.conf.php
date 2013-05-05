<?php

/**
 * cache
 * 
 * @author Jiaheng.Wu <gufei005@163.com>
 */
return array(
    "cache" => "filecache",
    "filecache" => WF_APP_PATH."cache/",
    "memcache" => array(
        array('host'=>'127.0.0.1','port'=>11211,'weight'=>3),
    ),
);

?>
