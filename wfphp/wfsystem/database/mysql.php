<?php

/**
 * mysql
 *
 * @author Jiaheng.Wu <gufei005@163.com>
 */
class Wfsystem_Database_Mysql implements Wfsystem_Database_Database{
    
    public $db = false;
    public $dbconfig = false;
    
    public function __construct($dbname=false) {
        $this->connect($dbname);
    }
    public function __destruct() {
        if($this->db && ! $this->dbconfig['connect']['persistent']){
            $this->close_connect($this->db);
        }
        
    }
    
    /**
     * 数据连接
     */
    public function connect($db){
        
        if( ! $db ){
            $dbarray = Wfsystem_Config::get("db");
            $this->dbconfig = $dbconfig = array_weight($dbarray);
        }else{
            $this->dbconfig = $dbconfig = Wfsystem_Config::get("db.{$db}");
        }
        
        if( ! $dbconfig || $dbconfig['type']!="mysql"){
            exit( "error 数据库配置文件错误！" );
        }
        
        if( ! $dbconfig['connect']['port']) $dbconfig['connect']['port'] = 3306;
        
        if($dbconfig['connect']['persistent']){
            $this->db = mysql_pconnect($dbconfig['connect']['hostname'].":".$dbconfig['connect']['port'],$dbconfig['connect']['username'],$dbconfig['connect']['password']);
        }else{
            $this->db = mysql_connect($dbconfig['connect']['hostname'].":".$dbconfig['connect']['port'],$dbconfig['connect']['username'],$dbconfig['connect']['password']);
        }
        
        if( ! $this->db){
            exit("error 不能连接到mysql");
        }
        if( ! mysql_select_db($dbconfig['connect']['database'],$this->db) ){
            exit("mysql错误：".mysql_error($this->db));
        }
        mysql_set_charset($dbconfig['charset'], $this->db);
        
        
    }
    
    /**
     * 关闭数据连接
     */
    public function close_connect(){
        mysql_close($this->db);
    }
    /*
     * 数据语句执行
     */
    public function query($sql){
        if($rs = mysql_query($sql,$this->db)){
            return $rs;
        }else{
            exit(mysql_error($this->db));
        }
    }
    
    public function select($sql ,$type="assoc",$single = false){
        $rs = $this->query($sql);
        $fetchfunc = "mysql_fetch_".$type;
        $array = false;
        if($single){
            $array = $fetchfunc($rs);
        }else{
            while($row = $fetchfunc($rs)){
                $array[] = $row;
            }
        }
        mysql_free_result($rs);
        return $array;
    }
    /**
     * 执行数据查询，返回所有结果
     * @param type $sql
     * @param type $type 
     */
    public function selectall($sql,$type){
        
    }
    /**
     * 执行数据查询，返回一条结果
     * @param type $sql
     * @param type $type
     */
    public function selectone($sql,$type){
        
    }
    /**
     * 得到最后一条新增数据的id
     */
    public function insert_id(){
        return mysql_insert_id($this->db);
    }
    /*
     * 得到最后一条语句影响的行数
     */
    public function affected_rows(){
        return mysql_affected_rows($this->db);
    }
    /**
     * 安全转义字符
     * @param type $str
     */
    public function escape_string($str){
        return mysql_real_escape_string($str, $this->db);
    }
    
}

?>
