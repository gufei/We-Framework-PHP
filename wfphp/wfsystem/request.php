<?php

/**
 * request
 *
 * @author Jiaheng.Wu <gufei005@163.com>
 */
class Wfsystem_Request {
    public static function init(){
        $_COOKIE = self::sanitize($_COOKIE);
        $_GET = self::sanitize($_GET);
        $_POST = self::sanitize($_POST);
    }
    
    public static function sanitize($value){
        if (is_array($value) OR is_object($value)){
            foreach ($value as $key => $val){
                $value[$key] = self::sanitize($val);
            }
        }elseif (is_string($value)){
            if (MAGIC_QUOTES_GPC === TRUE){
                $value = stripslashes($value);
            }

            if (strpos($value, "\r") !== FALSE){
                $value = str_replace(array("\r\n", "\r"), PHP_EOL, $value);
            }
        }

        return $value;
    }
    
    public static function getrequest($value,$type=null){
        if (is_array($value) OR is_object($value)){
            foreach ($value as $key => $val){
                $value[$key] = self::getrequest($val);
            }
        }elseif(is_string($value)){
            $value = addslashes($value);
        }
        
        switch($type){
            case "int":
                $value = (int) $value;
                break;
            case "bool":
                $value = (bool) $value;
                break;
            case "string":
                $value = (string) $value;
                break;
            case "float":
                $value = (float) $value;
                break;
            case "binary":
                $value = (binary) $value;
                break;
            case "array":
                $value = (array) $value;
                break;
            case "object":
                $value = (object) $value;
                break;
            case "unset":
                $value = (unset) $value;
                break;
        }
        
        return $value;
        
        
    }
}

?>
