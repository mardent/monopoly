<?php
ob_start();
	if(!defined('SEPARATOR')){
		define('SEPARATOR', getenv("COMSPEC")? ";" : ":");
		ini_set("include_path", ini_get("include_path").SEPARATOR.dirname(__FILE__));
	}
require_once 'core/lib.php';
require_once 'core/model.php';
require_once 'core/view.php';
require_once 'core/controller.php';
require_once 'core/router.php';
require_once 'core/user.php';
require_once 'core/exceptions.php';
require_once 'core/translation.php';

?>


