<?php

/**
 * db
 * 
 * @author Jiaheng.Wu <gufei005@163.com>
 */
return array(
    "db"=>array(
        "default"=>array(
            "weight"=>10,
            "type"=>"mysql",
            "connect"=>array(
                "hostname" => "localhost",
                "username" => "root",
                "password" => "",
                "port" => 3306,
                "persistent" => false,
                "database" => "test"
            ),
            "table_prefix" => "",
            "charset" => "utf8"
        ),
        "localhost"=>array(
            "weight"=>1,
            "type"=>"mysql",
            "connect"=>array(
                "hostname" => "localhost",
                "username" => "root",
                "password" => "",
                "port" => 3306,
                "persistent" => false,
                "database" => "test"
            ),
            "table_prefix" => "",
            "charset" => "utf8"
        )
    )
);
?>
