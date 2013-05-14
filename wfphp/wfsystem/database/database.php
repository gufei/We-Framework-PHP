<?php

/**
 * mysql
 *
 * @author Jiaheng.Wu <gufei005@163.com>
 */
interface Wfsystem_Database_Database {
    /**
     * 数据连接
     */
    public function connect($dbname);
    /**
     * 关闭数据连接
     */
    public function close_connect();
    /*
     * 数据语句执行
     */
    public function query($sql);
    /**
     * 执行数据查询，返回所有结果
     * @param type $sql
     * @param type $type 
     */
    public function selectall($sql,$type);
    /**
     * 执行数据查询，返回一条结果
     * @param type $sql
     * @param type $type
     */
    public function selectone($sql,$type);
    /**
     * 得到最后一条新增数据的id
     */
    public function insert_id();
    /*
     * 得到最后一条语句影响的行数
     */
    public function affected_rows();
    /**
     * 安全转义字符
     * @param type $str
     */
    public function escape_string($str);
    
    
}

?>
