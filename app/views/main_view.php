<?php 
	if(isset($_SESSION["lang"])){
		$translate = new Translator($_SESSION["lang"]);
	}else{
		$translate = new Translator('ru');
	}
?>
<fieldset class="login">
	<legend><?php $translate->__('Вход')?></legend>
		<form class="form">
			<section class="section_input">
				<label class="label" for="login"><?php $translate->__('Логин')?></label>
				<input class="input input_login" type="text" id="login" size="16" maxlength="30" placeholder="<?php $translate->__('логин')?>" >
				<div class="error-login" style=" margin-left:300px;"><?php $translate->__('Поле Логин обязательно для заполнения, длина имени должна составлять не менее 2 символов, поле может содержать только русские или латинские буквы и ( _ , - , . )') ?></div>
			</section>
			<section  class="section_input">
				<label class="label" for="password"><?php $translate->__('Пароль')?></label>
				<input class="input input_password" type="password" id="password" size="16" maxlength="128" placeholder="<?php $translate->__('пароль')?>">
				<div class="error-password" style=" margin-left:300px;"><?php $translate->__('Введите пароль. Не меньше 4 знаков.')?></div>
			</section>
			<section class="button">
				<button id="log"><?php $translate->__('Войти')?></button>
			</section>
			<a href="/register"><?php $translate->__('Регистрация')?></a> /
			<a href="/forgot_password"><?php $translate->__('Забыли пароль?')?></a>
		</form>
</fieldset>