<?php

/**
 * db
 *
 * @author Jiaheng.Wu <gufei005@163.com>
 */
class Wfsystem_Db {
    
    public $dbtype = false;
    public $dbconfig = false;
    public $dbname = false;
    public $db = false;
    
    
    public $_select = array();
    public $_from = array();
    public $_sql;
    
    public function database($dbname=false) {
        
        
        if($dbname){
            $this->dbconfig = Wfsystem_Config::get("db.{$dbname}");
            $this->dbtype = ucfirst(strtolower($this->dbconfig['type']));
            $this->dbname = $dbname;
        }else{
            $this->dbconfig = Wfsystem_Config::get("db");
            $this->dbtype = ucfirst(strtolower(Wfsystem_Config::get("dbtype")));
            $this->dbname = false;
        }
        
        if($this->dbtype && $this->dbconfig){
            $objname = "Wfsystem_Database_".$this->dbtype;
            $this->db = new $objname($this->dbname);
        }
        
        return $this;
    }
    
    public function select($columns = null){
        $columns = func_get_args();
        $this->_select = array_merge($this->_select, $columns);
        return $this;
    }
    
    public function from($table){
        $tables = func_get_args();
        $this->_from = array_merge($this->_from, $tables);
        return $this;
    }
    
    public function standardized($stand,$type){
        switch($type){
            case "select":
            case "from":
                foreach($stand as &$value){
                    if(is_string($value)){
                        $value = trim($value);
                        $value = str_replace(".", "`.`", $value);
                        $value = "`".$value."`";
                    }elseif(is_array($value)){
                        $value = "`".implode("` AS `", $value)."`";
                    }

                }
                break;
        }
        return $stand;
    }
    
    public function exec(){
        if($this->_select){
            $sql = "SELECT ".implode(" , ", $this->standardized($this->_select, "select"));
        }else{
            $sql = "SELECT *";
        }
        if($this->_from){
            $sql .= " FROM ".implode(" , ", $this->standardized($this->_from, "from"));
        }else{
            exit("error 没有from");
        }
        
        var_dump($sql);
        
    }
    
    
    
}

?>
