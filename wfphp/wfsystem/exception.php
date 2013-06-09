<?php

/**
 * exception
 *
 * @author Jiaheng.Wu <gufei005@163.com>
 */
class Wfsystem_Exception extends Exception {
    
    
    public function __construct($message = "", array $variables = NULL, $code = 0, Exception $previous = NULL)
	{
		// Set the message
		//$message = __($message, $variables);
        
        $message = strtr($message,$variables);

		// Pass the message and integer code to the parent
		parent::__construct($message, (int) $code, $previous);

		// Save the unmodified code
		// @link http://bugs.php.net/39615
		$this->code = $code;
	}
    
    public function __toString()
    {
        return Wfsystem_Exception::text($this);
    }
    
    public static function text(Exception $e)
    {
        return sprintf('%s [ %s ]: %s ~ %s [ %d ]',
                get_class($e),
                $e->getCode(),
                strip_tags($e->getMessage()),
                $e->getFile(),
                $e->getLine()
                );
    }
}

?>
