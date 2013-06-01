<?php

/**
 * Wfsystem_Autoload
 * 基于PHP5.3命名空间或PEAR类命名规范
 * 
 * 例：Doctrine\Common namespace.
 *      $classLoader = new Wfsystem_Autoload('Doctrine\Common', '/path/to/doctrine');
 *      $classLoader->register();
 * 
 * 参考：https://github.com/php-fig/fig-standards https://github.com/php-fig/fig-standards/blob/master/accepted/PSR-0.md
 * 
 *
 * @author Jiaheng.Wu <gufei005@163.com>
 */
class Wfsystem_Autoload 
{
    private $_fileExtension = EXT;
    private $_namespace;
    private $_includePath;
    private $_namespaceSeparator = '\\';
    
    /**
     * 声明类 new class 自动加载对应文件 include request
     * 
     * @param type $ns 命名空间声明 use
     * @param type $includePath
     */
    public function __construct($ns = null, $includePath = null) 
    {
        $this->_namespace = $ns;
        $this->_includePath = $includePath;
    }
    
    /**
     * 设置命名空间分割符
     * 
     * @param string $sep
     */
    public function setNamespaceSeparator($sep = '\\')
    {
        $this->_namespaceSeparator = $sep;
    }
    
    /**
     * 得到命名空间分割符
     * 
     * @return string
     */
    public function getNamespaceSeparator()
    {
        return $this->_namespaceSeparator;
    }
    
    /**
     * 设置包含件的基础路径
     * 
     * @param string $includePath
     */
    public function setIncludePath($includePath = null)
    {
        $this->_includePath = $includePath;
    }
    
    /**
     * 得到包含文件的基础路径
     * 
     * @return string
     */
    public function getIncludePath()
    {
        return $this->_includePath;
    }
    
    /**
     * 设置包含文件的扩展名
     * 
     * @param string $fileExtension
     */
    public function setFileExtension($fileExtension = '.php')
    {
        $this->_fileExtension = $fileExtension;
    }
    
    /**
     * 得到包含文件的扩展名
     * 
     * @return string
     */
    public function getFileExtension()
    {
        return $this->_fileExtension;
    }
    
    /**
     * PHP SPL 注册自动加载函数
     */
    public function register()
    {
        spl_autoload_register(array($this, 'loadClass'));
    }
    
    /**
     * PHP SPL 注销自动加载函数
     */
    public function unregister()
    {
        spl_autoload_unregister(array($this, 'loadClass'));
    }
    
    /**
     * 自动装载类或接口文件
     * 首先判断是否在autoload配置文件中有定义，有的话直接加载
     * 判断是否是命名空间，如果是，则按命名空间生成对应目录
     * 根据类名生成文件路径
     * 
     * @param string $className
     * @return void
     */
    public function loadClass($className)
    {
        require_once WF_SYS_SYSTEM_PATH . 'config' . EXT;
        if ( ! ($fileName = Wfsystem_Config::get("autoload.".$className))) {
            
            $className = ltrim($className, $this->_namespaceSeparator);
            $fileName = '';
            $namespace = '';

            if ($last_namespace_position = strripos($className, $this->_namespaceSeparator)) {
                echo "aaa";
                $namespace = substr($className, 0, $last_namespace_position);
                $className = substr($className, $last_namespace_position + 1);
                $fileName = str_replace($this->_namespaceSeparator, DIRECTORY_SEPARATOR, $namespace) . DIRECTORY_SEPARATOR;
            }
            
            if (empty($fileName)) {
                $fileName = str_replace('_', DIRECTORY_SEPARATOR, $className) . $this->_fileExtension;
            } else {
                $fileName .= str_replace('_', DIRECTORY_SEPARATOR, $fileName) . $this->_fileExtension;
            }

            $fileName = strtolower($fileName);
            
            
            
            
            if ($this->_includePath !== null) {
                $fileName = $this->_includePath . DIRECTORY_SEPARATOR . $fileName;
            } else {
                if (substr($fileName, 0, 2) == 'wf') {
                    $fileName = WF_SYS_PATH . $fileName;
                } else {
                    $fileName = WF_APP_PATH . $fileName;
                }
            }
            
        }
        
        
        
        if (file_exists($fileName)) {
            require_once $fileName;
        } else {
            return false;
        }
        
    }
    
}

?>
