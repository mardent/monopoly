
<html>
	<head>
		<meta http-equiv="content-type" content="text/html; charset=utf-8">
		<meta name="description" content="Игра в Монополию онлайн">
		<meta name="keywords" content="Монополия, играть в монополию, монополия онлайн, монополия с друзьями онлайн">
		<link rel="stylesheet" type="text/css" href="../css/style.css">
		<link type="text/css" rel="stylesheet" href="../css/errorlist.css"></link>
		<script src="js/jquery-2.1.3.js"></script>
		<script src="js/create_rooms.js"></script>
		<title>Монополия</title>
		
	</head>

	<body>
	<legend>Регистрация</legend>
				<form class="form">
				<table>
					<tr>
						<td><label class="label" for="name">Название*</label></td>
						<td><input class="input" type="text" name="name" id="name" size="16" maxlength="30"
									placeholder="название" />
									<div class="error-login"></div>
									</td>
						
					</tr>
					<tr>
						<td><label class="label" for="password">Пароль*</label></td>
						<td><input class="input" type="password" id="password" size="16" maxlength="128"
								   placeholder="пароль">
								   <div class="error-password"></div>
								   </td>
					</tr>
					<tr>
						<td><label class="label" for="players">Игроки*</label></td>
						<td><input class="input" type="text" id="players" size="16" maxlength="128"
								   placeholder="" >
								    <div class="error-confirm"></div>
								   </td>
					</tr>
					<tr>
						<td><label class="label" for="money">Деньги*</label></td>
						<td><input class="input" type="text" id="money" size="16" maxlength="50"
								   placeholder="" >
						          <div class="error-name"></div>
						          </td>
					</tr>
					<tr>
						<td><label class="label" for="time">Время хода*</label></td>
						<td><input class="input" type="text" name="time" id="time" size="16" maxlength="50" 
								   placeholder="">
								   <div class="error-email"></div>
								   </td>
					</tr>
				</table>	
				<section class = "button">
					<button  id="createroom"  class="reg">Далее</button>
				</section>
				</form>
				<div class="message" id="message"></div>
	</body>		
</html>
