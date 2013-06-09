<?php

/**
 * @author jiaheng.wu
 * @copyright 2013.6.8
 */

abstract class Wfsystem_Database
{
    const SELECT =  1;
    const INSERT =  2;
    const UPDATE =  3;
    const DELETE =  4;
    
    //默认数据库配置名称
    public static $default = 'default';
    
    //数据库连接类数组
    public static $instances = array();
    
    public static function instance($name = NULL, array $config = NULL)
	{
		if ($name === NULL)
		{
			// Use the default instance name
			$name = Wfsystem_Database::$default;
		}

		if ( ! isset(Wfsystem_Database::$instances[$name]))
		{
			if ($config === NULL)
			{
                $config = Wfsystem_Config::get("db.{$name}");
				// Load the configuration for this database
				//$config = Kohana::$config->load('database')->$name;
			}

			if ( ! isset($config['type']))
			{
				throw new Wfsystem_Exception('数据库配置错误 :name ',
					array(':name' => $name));
			}

			// Set the driver class name
            
            $driver = "Wfsystem_Database_".ucfirst($config['type']);

			// Create the database connection instance
			$driver = new $driver($name, $config);

			// Store the database instance
			Wfsystem_Database::$instances[$name] = $driver;
		}

		return Wfsystem_Database::$instances[$name];
	}
    
    
    protected $_instance;
    
    protected $_config;
    
    public function __construct($name, array $config)
	{
		// Set the instance name
		$this->_instance = $name;

		// Store the config locally
		$this->_config = $config;

		if (empty($this->_config['table_prefix']))
		{
			$this->_config['table_prefix'] = '';
		}
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
			if ($value instanceof Wfsystem_Db_Query)
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
    
}

?>