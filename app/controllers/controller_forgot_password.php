<?php

class Controller_forgot_password extends Controller
{

	function action_index()
	{	
		$this->view->generate('forgot_password_view.php', 'template_view.php');
	}
	
	function action_recover($data = null)
	{	
		$this->view->generate('forgot_password_view.php', 'template_view.php', $data);
	}
	
}
?>