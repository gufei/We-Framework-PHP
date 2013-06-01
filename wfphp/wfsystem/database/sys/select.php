<?php

/**
 * select
 *
 * @author Jiaheng.Wu <gufei005@163.com>
 */
class Wfsystem_Database_Sys_Select {
    
    protected $_select = array();
    protected $_from = array();
    
    public function __construct(array $param = NULL) {
        if( !empty($param)){
            $this->_select = $param;
        }
    }
    
    public function select($param = NULL){
        $param = func_get_args();
        $this->_select = array_merge($this->_select, $param);
        return $this;
    }
    
    public function select_array(array $param){
        $this->_select = array_merge($this->_select, $param);
        return $this;
    }
    
    public function from($tables){
        $tables = func_get_args();

        $this->_from = array_merge($this->_from, $tables);

        return $this;
    }
    
    
    public function build_query($db = NULL){
        
        
        if ( ! is_object($db)){
            $db = Wfsystem_Database_Database::database($db);
            
        }
        
        $quote_param = array($db, 'quote_param');
        $quote_table = array($db, 'quote_table');
        
        $query = 'SELECT ';
        
        if (empty($this->_select)){
            $query .= '*';
        }else{
            $query .= implode(', ', array_unique(array_map($quote_param, $this->_select)));
        }
        
        if ( ! empty($this->_from)){
            $query .= ' FROM '.implode(', ', array_unique(array_map($quote_table, $this->_from)));
        }
        
        return $query;
        
    }
    
    
    public function __toString(){
        try
        {
                // Return the SQL string
                return $this->build_query(Wfsystem_Database_Database::database());
        }
        catch (Exception $e)
        {
                //return Kohana_Exception::text($e);
        }
    }
}

?>
