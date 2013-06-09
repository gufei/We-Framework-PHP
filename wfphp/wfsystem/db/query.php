<?php

/**
 * SQL query语句类
 * 
 * $query = Wfsystem_Db::query(Wfsystem_Database_Database::SELECT, 'SELECT * FROM users WHERE username = :user');
 * $query->param(':user', 'jiaheng.wu');
 * $query->execute();
 * 
 * @author jiaheng.wu
 * @copyright 2013.6.7
 */

class Wfsystem_Db_Query
{
    // Query 类型
	protected $_type;
    
    // SQL 语句
	protected $_sql;
    
    // 需要替换的数据
    protected $_parameters = array();
    
    // 返回数据格式数组(array)或对象(object)
    protected $_as_object = FALSE;
    
    // 返回数据为对象格式时使用
    protected $_object_params = array();
    
    /**
     * 初始化
     * Wfsystem_Db_Query::__construct()
     * 
     * $query = Wfsystem_Db::query(Wfsystem_Database_Database::SELECT, 'SELECT * FROM users WHERE username = :user');
     * 
     * @param mixed $type
     * @param mixed $sql
     * @return void
     */
    public function __construct($type, $sql)
	{
		$this->_type = $type;
		$this->_sql = $sql;
	}
    
    /**
	 * 返回 SQL 语句.
	 *
	 * @return  string
	 */
	public function __toString()
	{
		try
		{
			// 返回处理后的SQL语句
			return $this->compile(Wfsystem_Database_Database::instance());
		}
		catch (Exception $e)
		{
			return Wfsystem_Exception::text($e);
		}
	}
    
    /**
     * 得到SQL类型
     * Wfsystem_Db_Query::type()
     * 
     * @return
     */
    public function type()
	{
		return $this->_type;
	}
    
    /**
     * 设置返回数据为数组方式
     * Wfsystem_Db_Query::as_assoc()
     * 
     * @return
     */
    public function as_assoc()
	{
		$this->_as_object = FALSE;

		$this->_object_params = array();

		return $this;
	}
    
    /**
     * 设置返回数据为对象方式
     * Wfsystem_Db_Query::as_object()
     * 
     * @param bool $class 此项为true时使用对象方式
     * @param mixed $params
     * @return
     */
    public function as_object($class = TRUE, array $params = NULL)
	{
		$this->_as_object = $class;

		if ($params)
		{
			$this->_object_params = $params;
		}

		return $this;
	}
    
    /**
     * 设置替换数据
     * Wfsystem_Db_Query::param()
     * 
     * $query->param(':user', 'jiaheng.wu');
     * 
     * @param mixed $param
     * @param mixed $value
     * @return
     */
    public function param($param, $value)
	{
		$this->_parameters[$param] = $value;

		return $this;
	}
    
    /**
     * 修正替换数据
     * Wfsystem_Db_Query::bind()
     * 
     * $query = DB::query(Database::INSERT, 'INSERT INTO users (username, password) VALUES (:user, :pass)')
            ->bind(':user', $username)
            ->bind(':pass', $password);
         
        foreach ($new_users as $username => $password)
        {
            $query->execute();
        }
     * 
     * @param mixed $param
     * @param mixed $var
     * @return
     */
    public function bind($param, & $var)
	{
		$this->_parameters[$param] =& $var;

		return $this;
	}
    
    /**
     * 批量设置替换数据
     * Wfsystem_Db_Query::parameters()
     * 
     * $query->parameters(array(
            ':user' => 'john',
            ':status' => 'active',
        ));
     * 
     * @param mixed $params
     * @return
     */
    public function parameters(array $params)
	{
		$this->_parameters = $params + $this->_parameters;

		return $this;
	}
    
    /**
	 * 处理SQL语句
	 *
	 * @param   mixed  $db  数据库连接
	 * @return  string
	 */
	public function compile($db = NULL)
	{
		if ( ! is_object($db))
		{
			// 得到数据库连接
			$db = Wfsystem_Database_Database::instance($db);
		}

		// SQL语句
		$sql = $this->_sql;

		if ( ! empty($this->_parameters))
		{
			// 对需要替换的数据进行验证
			$values = array_map(array($db, 'quote'), $this->_parameters);

			// 数据替换
			$sql = strtr($sql, $values);
		}

		return $sql;
	}
    
    
    /**
     * 执行SQL语句
     * Wfsystem_Db_Query::execute()
     * 
     * $result = $query->execute('config_name')
     * 
     * @param mixed $db
     * @param mixed $as_object
     * @param mixed $object_params
     * @return
     */
    public function execute($db = NULL, $as_object = NULL, $object_params = NULL)
	{
		if ( ! is_object($db))
		{
			// Get the database instance
			$db = Wfsystem_Database_Database::instance($db);
		}

		if ($as_object === NULL)
		{
			$as_object = $this->_as_object;
		}

		if ($object_params === NULL)
		{
			$object_params = $this->_object_params;
		}

		// 得到处理后的sql语句
		$sql = $this->compile($db);

		

		// Execute the query
		$result = $db->query($this->_type, $sql, $as_object, $object_params);

		

		return $result;
	}
    
}

?>