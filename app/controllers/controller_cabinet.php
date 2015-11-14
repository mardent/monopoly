<?php
	class Controller_cabinet extends Controller {
		
		function action_index (){
			$this->view->generate('cabinet_view.php', 'template_view.php');
		}
	}
?>