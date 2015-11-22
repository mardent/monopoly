<?php
$_SESSION['captcha_session'] = substr(md5(uniqid("")), 0, 5);
	if(isset($_SESSION["lang"])){
		$translate = new Translator($_SESSION["lang"]);
	}else{
		$translate = new Translator('ru');
	}
?>


<fieldset class="register"  >
	<legend><?php $translate->__('Регистрация')?></legend>
				<form class="form">
				<table>
					<tr>
						<td><label class="label" for="login"><?php $translate->__('Логин*')?></label></td>
						<td><input class="input" type="text" name="login" id="login" size="16" maxlength="30"
									placeholder="<?php $translate->__('логин')?>" />
									<div class="error-login"><?php $translate->__('Поле Логин обязательно для заполнения, длина имени должна составлять не менее 2 символов, поле может содержать только русские или латинские буквы и ( _ , - , . )') ?></div>
									</td>
						
					</tr>
					<tr>
						<td><label class="label" for="password"><?php $translate->__('Пароль*')?></label></td>
						<td><input class="input" type="password" id="password" size="16" maxlength="128"
								   placeholder="<?php $translate->__('пароль')?>">
								   <div class="error-password"><?php $translate->__('Введите пароль. Не меньше 4 знаков.')?></div>
								   </td>
					</tr>
					<tr>
						<td><label class="label" for="confirm"><?php $translate->__('Подтверждение*')?></label></td>
						<td><input class="input" type="password" id="confirm" size="16" maxlength="128"
								   placeholder="<?php $translate->__('подтверждение')?>" >
								    <div class="error-confirm"></div>
								   </td>
					</tr>
					<tr>
						<td><label class="label" for="name"><?php $translate->__('Имя*')?></label></td>
						<td><input class="input" type="text" id="name" size="16" maxlength="50"
								   placeholder="<?php $translate->__('имя')?>" >
						          <div class="error-name"><?php $translate->__('Поле Имя обязательно для заполнения. Длина не менее 2 символов и может содержать только русские или латинские буквы')?></div>
						          </td>
					</tr>
					<tr>
						<td><label class="label" for="email"><?php $translate->__('E-mail*')?></label></td>
						<td><input class="input" type="text" name="email" id="email" size="16" maxlength="50" 
								   placeholder="<?php $translate->__('e-mail')?>">
								   <div class="error-email"><?php $translate->__('Содержимое поля "Email" не является email адресом')?></div>
								   </td>
					</tr>
					<tr>
						<td></td>
						<td><img alt="" id="captcha_image" src="app/core/site_lib/gen_captcha.php">
							<a href="#" onclick="document.getElementById('captcha_image').src='app/core/site_lib/gen_captcha.php?'+Math.random();return false;"><img alt="<?php $translate->__('Обновить')?>" src="../../images/refresh.png">
						</td>
					</tr>
					<tr>
						<td><label class="label" for="captcha"><?php $translate->__('Введите капчу*')?></label></td>
						<td><input class="input" type="text" name="captcha" id="captcha" size="6" maxlength="15"
									placeholder="<?php $translate->__('капча')?>">
									<div class="error-captcha"><?php $translate->__('Введите символы с картинки')?></div>
									</td>
					</tr>
				</table>
				<section class = "button">
					<button type="button" id="back" onClick="clickBack()"><?php $translate->__('Назад')?></button>
					<button  id="reg"  class="reg"><?php $translate->__('Далее')?></button>
				</section>
				</form>
	</fieldset>
	