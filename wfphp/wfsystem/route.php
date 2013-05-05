<?php

/**
 * route
 *
 * @author Jiaheng.Wu <gufei005@163.com>
 */
class Wfsystem_Route {
    
    public $controller;
    public $action;
    
    // 保存类实例在此属性中
    private static $instance;
    
    // 构造方法声明为private，防止直接创建对象
    private function __construct() {}

    // singleton 方法
    public static function singleton() {
        if (!isset(self::$instance)) {
            $c = __CLASS__;
            self::$instance = new $c;
        }

        return self::$instance;
    }
    // 阻止用户复制对象实例
    public function __clone(){
        trigger_error('Clone is not allowed.', E_USER_ERROR);
    }
    
    public function route(){
        if($this->controller = $this->inst_controller()){
            $this->action = $this->execute_action();
        }
    }
    
    public function inst_controller(){
        $current_file_name = ltrim(strrchr($_SERVER['SCRIPT_FILENAME'],DIRECTORY_SEPARATOR),DIRECTORY_SEPARATOR);
        $app_controller_path = Wfsystem_Config::get("path.app_controller");
        if(isset($_GET['c']) && file_exists($app_controller_path.Wfsystem_Request::getrequest($_GET['c']).".php")){
            $controller = ucfirst(basename($app_controller_path))."_".ucfirst(Wfsystem_Request::getrequest($_GET['c']));
        }elseif(isset($_GET['controller']) && file_exists($app_controller_path.Wfsystem_Request::getrequest($_GET['controller']).".php")){
            $controller = ucfirst(basename($app_controller_path))."_".ucfirst(Wfsystem_Request::getrequest($_GET['controller']));
        }elseif(file_exists($app_controller_path.$current_file_name)){
            $controller = ucfirst(basename($app_controller_path))."_".ucfirst(rtrim($current_file_name,".php"));
        }else{
            return false;
        }
        return new $controller;
        
    }
    
    public function execute_action(){
        
        if(isset($_GET['a']) && method_exists($this->controller, Wfsystem_Request::getrequest($_GET['a']))){
            $action = Wfsystem_Request::getrequest($_GET['a']);
        }elseif(isset($_GET['action']) && method_exists($this->controller, Wfsystem_Request::getrequest($_GET['action']))){
            $action = Wfsystem_Request::getrequest($_GET['action']);
        }elseif(method_exists($this->controller, "__empty")){
            $action = "__empty";
        }
        
        $this->controller->$action();
    }
}

?>
