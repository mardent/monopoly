<?php
ob_start();
	if(!defined('SEPARATOR')){
		define('SEPARATOR', getenv("COMSPEC")? ";" : ":");
		ini_set("include_path", ini_get("include_path").SEPARATOR.dirname(__FILE__));
	}
require_once 'core/model.php';
require_once 'core/view.php';
require_once 'core/controller.php';
require_once 'core/site_lib/func_lib.php';
require_once 'core/site_lib/link_crypt.php';
require_once 'router.php';
require_once 'core/database/user.php';
require_once 'core/exceptions/exceptions.php';
require_once 'core/site_lib/translation.php';

?>


