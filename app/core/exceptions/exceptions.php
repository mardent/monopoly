<?php
	require_once 'interfaces.php';
	class MyExceptions extends Exception implements IException  {
			private $name;
			function __construct ($name){
				parent::__construct($name);
				$this->name = $name;
			}
			
			public function ForbiddenRequest (){
				include 'app/views/error_403_view.php';
			}
			
			function __destruct(){
				echo "</div>",
					 "<hr size='3'>",
					 "<div class='footer'>",
					 "</div>",
					 "<div>";
			}
	}
		
	class NotFound extends Exception implements IFilesException {
			public function Error (){
				include "app/controllers/controller_error_pages.php";
				$controller = new Controller_error_pages;
				$action = 'action_404';
				$controller->$action();
			}
	}	
		
	class Forbidden extends Exception implements IFilesException {
			public function Error (){
				include "app/controllers/controller_error_pages.php";
				$controller = new Controller_error_pages;
				$action = 'action_403';
				$controller->$action();
			}
	}	
	
	
?>