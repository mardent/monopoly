<?php
session_start(); 
ini_set('display_errors', 1);
error_reporting(E_ALL);                                        
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
		<script src="../js/check_cookie.js"></script>
		<script src="../js/profile_view.js"></script>
		<title>Монополия</title>
		<noscript>
		<font color='red'><div class="clear h20"></div><h1>Внимание! У Вас отключена поддержка JavaScript!</h1></font>Для продолжения работы необходимо включить функцию JavaScript в настройках вашего браузера<br>
		</noscript>
		<script type='text/javascript'>
		if (enabled==null) document.write('<h1>Внимание! У Вас отключена поддержка Cookie!</h1>Для продолжения работы необходимо включить поддержку Cookie в настройках вашего браузера');
		</script>
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
