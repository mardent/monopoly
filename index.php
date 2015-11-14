<?php
session_start(); 
ini_set('display_errors', 1);
error_reporting(E_ALL & ~E_NOTICE);                                        
	setcookie('on','1');
	if(!@$_COOKIE['on']){
		echo "Для корректной работы сайта влючите cookie";
	}
require_once 'app/start.ini.php';
?>
<!doctype html>
<html>
	<head>
		<meta http-equiv="content-type" content="text/html; charset=utf-8">
		<meta name="description" content="Игра в Монополию онлайн">
		<meta name="keywords" content="Монополия, играть в монополию, монополия онлайн, монополия с друзьями онлайн">
		<link rel="stylesheet" type="text/css" href="../css/style.css">
		<link type="text/css" rel="stylesheet" href="../css/errorlist.css"></link>
		<script src="../js/jquery-2.1.3.js"></script>
		<script src="../js/check_form.js"></script>
		<script src="../js/spin.min.js"></script>
		<title>Монополия</title>
	</head>
<?php

try{
	Route::start(); // запуск маршрутизатора
}catch (Forbidden $e){
	$e->Error();	
}catch (NotFound $e){
	$e->Error();
}catch (MyExceptions $e){
	echo "<h2>Ссылка не действительна</h2>";
	header( 'Refresh: 3; url=/' );
	$e->ForbiddenRequest();
}

?>
</html>