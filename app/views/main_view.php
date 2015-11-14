<fieldset class="login">
	<legend>Вход</legend>
		<form class="form">
			<section class="section_input">
				<label class="label" for="login">Логин</label>
				<input class="input input_login" type="text" id="login" size="16" maxlength="30" placeholder="логин">
				<div class="error-login" style=" margin-left:300px;"></div>
			</section>
			<section  class="section_input">
				<label class="label" for="password">Пароль</label>
				<input class="input input_password" type="password" id="password" size="16" maxlength="128" placeholder="пароль">
				<div class="error-password" style=" margin-left:300px;"></div>
			</section>
			<section class="button">
				<button id="log">Войти</button>
			</section>
			<a href="/register">Регистрация</a> /
			<a href="/forgot_password">Забыли пароль?</a>
		</form>
		<div class="message" style=" margin-left:30px;"></div>
</fieldset>