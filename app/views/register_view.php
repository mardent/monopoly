<?php
$_SESSION['captcha_session'] = substr(md5(uniqid("")), 0, 5);
?>


<fieldset class="register"  >
	<legend>Регистрация</legend>
				<form class="form">
				<table>
					<tr>
						<td><label class="label" for="login">Логин*</label></td>
						<td><input class="input" type="text" name="login" id="login" size="16" maxlength="30"
									placeholder="логин" />
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
						<td><label class="label" for="confirm">Подтверждение*</label></td>
						<td><input class="input" type="password" id="confirm" size="16" maxlength="128"
								   placeholder="подтверждение" >
								    <div class="error-confirm"></div>
								   </td>
					</tr>
					<tr>
						<td><label class="label" for="name">Имя*</label></td>
						<td><input class="input" type="text" id="name" size="16" maxlength="50"
								   placeholder="имя" >
						          <div class="error-name"></div>
						          </td>
					</tr>
					<tr>
						<td><label class="label" for="email">E-mail*</label></td>
						<td><input class="input" type="text" name="email" id="email" size="16" maxlength="50" 
								   placeholder="e-mail">
								   <div class="error-email"></div>
								   </td>
					</tr>
					<tr>
						<td></td>
						<td><img alt="" id="captcha_image" src="app/inc/captcha.php"></td>
					</tr>
					<tr>
						<td><label class="label" for="captcha">Введите капчу*</label></td>
						<td><input class="input" type="text" name="captcha" id="captcha" size="6" maxlength="15"
									placeholder="капча">
									<div class="error-captcha"></div>
									</td>
					</tr>
					<tr>
						<td><p><a href="#" onclick="document.getElementById('captcha_image').src='app/inc/captcha.php?'+Math.random();return false;">Обновить капчу</a>?</p></td>
					</tr>
				</table>
				<section class = "button">
					<button type="button" id="back" onClick="clickBack()">Назад</button>
					<button  id="reg"  class="reg">Далее</button>
				</section>
				</form>
				<div class="message" id="message"></div>
	</fieldset>
	