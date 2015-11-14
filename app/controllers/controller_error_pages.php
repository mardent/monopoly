<?php
	class Controller_error_pages extends Controller {
		
		function action_404 (){
			$this->view->generate('error_404_view.php', 'template_view.php');
		}
		
		function action_403 (){
			$this->view->generate('error_403_view.php', 'template_view.php');
		}
	}
?>