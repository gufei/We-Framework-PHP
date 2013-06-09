<?php

/**
 * mysql
 *
 * @author Jiaheng.Wu <gufei005@163.com>
 */
abstract class Wfsystem_Database_Database {
    const SELECT =  1;
    const INSERT =  2;
    const UPDATE =  3;
    const DELETE =  4;
    
    public static $database = array();
    
    protected $_identifier = '"';
    
    protected $_config;
    
    /**
     * 返回数据连接类
     * @param type $dbname
     * @return \objname
     */
    public static function instance($dbname=false) {
        
        $name = $dbname ? $dbname : "all";
        
        if( ! isset(self::$database[$name])){
            if($dbname){
                $dbconfig = Wfsystem_Config::get("db.{$dbname}");
                $dbtype = ucfirst(strtolower($dbconfig['type']));
            }else{
                $dbconfig = Wfsystem_Config::get("db");
                $dbtype = ucfirst(strtolower(Wfsystem_Config::get("dbtype")));
            }

            if($dbtype && $dbconfig){
                $objname = "Wfsystem_Database_".$dbtype;
                $db = new $objname($dbname);
            } else {
                throw new Wfsystem_Exception('数据库配置不存在:'.$name);
            }

            
            self::$database[$name] = $db;
        }
        return self::$database[$name];
    }
    
    public function quote($value)
	{
		if ($value === NULL)
		{
			return 'NULL';
		}
		elseif ($value === TRUE)
		{
			return "'1'";
		}
		elseif ($value === FALSE)
		{
			return "'0'";
		}
		elseif (is_object($value))
		{
			if ($value instanceof Database_Query)
			{
				// Create a sub-query
				return '('.$value->compile($this).')';
			}
			elseif ($value instanceof Database_Expression)
			{
				// Compile the expression
				return $value->compile($this);
			}
			else
			{
				// Convert the object to a string
				return $this->quote( (string) $value);
			}
		}
		elseif (is_array($value))
		{
			return '('.implode(', ', array_map(array($this, __FUNCTION__), $value)).')';
		}
		elseif (is_int($value))
		{
			return (int) $value;
		}
		elseif (is_float($value))
		{
			// Convert to non-locale aware float to prevent possible commas
			return sprintf('%F', $value);
		}

		return $this->escape($value);
	}
    
    public function quote_param($column){
        $escaped_identifier = $this->_identifier.$this->_identifier;
        if (is_array($column)){
            list($column, $alias) = $column;
            $alias = str_replace($this->_identifier, $escaped_identifier, $alias);
        }
        
        if(is_string($column)){
            $column = (string) $column;

            $column = str_replace($this->_identifier, $escaped_identifier, $column);

            if ($column === '*'){
                return $column;
            }elseif(strpos($column, '.') !== FALSE){
                $parts = explode('.', $column);

                if ($prefix = $this->table_prefix()){
                    $offset = count($parts) - 2;
                    $parts[$offset] = $prefix.$parts[$offset];
                }

                foreach ($parts as & $part){
                    if ($part !== '*'){
                        $part = $this->_identifier.$part.$this->_identifier;
                    }
                }

                $column = implode('.', $parts);
            }else{
                $column = $this->_identifier.$column.$this->_identifier;
            }
            
            if (isset($alias)){
                $column .= ' AS '.$this->_identifier.$alias.$this->_identifier;
            }

            return $column;
        }
    }
    
    
    public function quote_table($table){
        $escaped_identifier = $this->_identifier.$this->_identifier;

        if (is_array($table)){
            list($table, $alias) = $table;
            $alias = str_replace($this->_identifier, $escaped_identifier, $alias);
        }

        if(is_string($table)){
            $table = (string) $table;

            $table = str_replace($this->_identifier, $escaped_identifier, $table);

            if (strpos($table, '.') !== FALSE){
                $parts = explode('.', $table);

                if ($prefix = $this->table_prefix()){
                    $offset = count($parts) - 1;
                    $parts[$offset] = $prefix.$parts[$offset];
                }

                foreach ($parts as & $part){
                    $part = $this->_identifier.$part.$this->_identifier;
                }

                $table = implode('.', $parts);
            }else{
                $table = $this->_identifier.$this->table_prefix().$table.$this->_identifier;
            }
        }

        if (isset($alias)){
            $table .= ' AS '.$this->_identifier.$this->table_prefix().$alias.$this->_identifier;
        }

        return $table;
    }
    
    public function table_prefix(){
        return $this->_config['table_prefix'];
    }

    
    
    
    /**
     * 数据连接
     */
    abstract public function connect($dbname);
    /**
     * 关闭数据连接
     */
    abstract public function close_connect();
    /*
     * 数据语句执行
     */
    abstract public function query($sql);
    /**
     * 执行数据查询，返回所有结果
     * @param type $sql
     * @param type $type 
     */
    abstract public function selectall($sql,$type);
    /**
     * 执行数据查询，返回一条结果
     * @param type $sql
     * @param type $type
     */
    abstract public function selectone($sql,$type);
    /**
     * 得到最后一条新增数据的id
     */
    abstract public function insert_id();
    /*
     * 得到最后一条语句影响的行数
     */
    abstract public function affected_rows();
    /**
     * 安全转义字符
     * @param type $str
     */
    abstract public function escape($str);
    
    
    
    
    
    
}

?>
