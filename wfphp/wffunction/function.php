<?php

/**
 * function
 * 
 * @author Jiaheng.Wu <gufei005@163.com>
 */

/**
 * 根据数组指定权重返回随机值
 * 
 * @param type $array
 * @param type $flied
 * @return boolean|array
 */
function array_weight($array=false,$flied="weight"){
    if( ! $array || ! is_array($array)){
        return false;
    }
    $tmp_array = array();
    foreach( $array as $key => $value ){
        if(isset($value[$flied]) && $value[$flied]){
            for( $i=0;$i<((int) $value[$flied]);$i++ ){
                array_push($tmp_array, $key);
            }
        }
    }
    
    if($tmp_array){
        $tmpkey = array_rand($tmp_array);
        return $array[$tmp_array[$tmpkey]];
    }else{
        return false;
    }
    
}
?>
