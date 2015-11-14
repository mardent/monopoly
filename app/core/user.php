<?php
class User { 
    
	var $login;
	var $password;
	var $name;
	var $email;
	var $avatar;
	
	function User($login, $password, $name, $email, $avatar) {
		$this->login = $login;
		$this->password = $password;
		$this->name = $name;
		$this->email = $email;
		$this->avatar = $avatar;
	}
}
?>