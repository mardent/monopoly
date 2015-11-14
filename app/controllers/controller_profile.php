<?php

class Controller_profile extends Controller
{

	function action_index()
	{	
		$this->view->generate('profile_view.php', 'template_view.php');
	}
}
?>