<?php

/***
 * Name:       TinyMVC
 * About:      An MVC application framework for PHP
 * Copyright:  (C) 2007-2008 Monte Ohrt, All rights reserved.
 * Author:     Monte Ohrt, monte [at] ohrt [dot] com
 * License:    LGPL, see included license file  
 ***/

// ------------------------------------------------------------------------

/**
 * TinyMVC_ExceptionHandler
 * 
 * A simple exception handler to display exceptions in a formatted box.
 *
 * @package		TinyMVC
 * @author		Monte Ohrt
 */

class TinyMVC_ExceptionHandler extends ErrorException {
  
	/**
	 * printException
	 *
	 * @access	public
	 */    
  public static function printException(Exception $e)
  {
    switch ($e->getCode()) {
        case E_ERROR:
				  $code_name = 'E_ERROR';
        break;
        case E_WARNING:
				  $code_name = 'E_WARNING';
        break;
        case E_PARSE:
				  $code_name = 'E_PARSE';
        break;
        case E_NOTICE:
				  $code_name = 'E_NOTICE';
        break;
        case E_CORE_ERROR:
				  $code_name = 'E_CORE_ERROR';
        break;
        case E_CORE_WARNING:
				  $code_name = 'E_CORE_WARNING';
        break;
        case E_COMPILE_ERROR:
				  $code_name = 'E_COMPILE_ERROR';
        break;
        case E_COMPILE_WARNING:
				  $code_name = 'E_COMPILE_WARNING';
        break;
        case E_USER_ERROR:
				  $code_name = 'E_USER_ERROR';
        break;
        case E_USER_WARNING:
				  $code_name = 'E_USER_WARNING';
        break;
        case E_USER_NOTICE:
				  $code_name = 'E_USER_NOTICE';
        break;
        case E_STRICT:
				  $code_name = 'E_STRICT';
        break;
        case E_RECOVERABLE_ERROR:
				  $code_name = 'E_RECOVERABLE_ERROR';
        break;
				default:
				  $code_name = $e->getCode();
			  break;
	  }
	  ?>
    {
      "error": <?php echo json_encode($code_name); ?>,
      "message": <?php echo json_encode($e->getMessage()); ?><?php if (isset($_GET['debug'])) { ?>,
      "file": <?php echo json_encode($e->getFile()); ?>,
      "line": <?php echo json_encode($e->getLine()); ?>
      <?php } ?>
    }
	  <?php
  }
  
	/**
	 * handleException
	 *
	 * @access	public
	 */    
  public static function handleException(Exception $e)
  {
       return self::printException($e);
  }
}

?>