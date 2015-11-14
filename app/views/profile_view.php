<br>
<center><h1>Профиль</h1>

<? @$user =  unserialize($_SESSION["user"]) ?>

<br>
<img
	src=<?= "/images/avatars/".@$user->avatar?>
	style="width:304px;height:300px;">
<br>
<button id="changeAvatar" onClick="">Изменить</button>
<button id="deleteAvatar" onClick="">Удалить</button>
<fieldset class="profile" >
				<form class="form">
				<table>
					<tr>
						<td><label class="label">Логин</label></td>
						<td><?= @$user->login ?></td>
					</tr>
					<tr>
						<td><label class="label">Email</label></td>
						<td><?= @$user->email ?></td>
					</tr>
					<tr>
						<td><label class="label" for="old">Старый пароль</label></td>
						<td><input class="input" type="password" id="old" size="16" maxlength="128"
								   placeholder="пароль">
								   <div class="error-password"></div>
								   </td>
					</tr>
					<tr>
						<td><label class="label" for="password">Новый пароль</label></td>
						<td><input class="input" type="password" id="password" size="16" maxlength="128"
								   placeholder="новый" >
								    <div class="error-password"></div>
								   </td>
					</tr>
					<tr>
						<td><label class="label" for="confirm">Подтверждение пароля</label></td>
						<td><input class="input" type="password" id="confirm" size="16" maxlength="50"
								   placeholder="подтверждение" >
						          <div class="error-confirm"></div>
						          </td>
					</tr>
				</table>
				<section class = "button">
					<button type="button" id="back" onClick="clickBack()">Назад</button>
					<button type="button" id="changePass" >Изменить</button>
				</section>
				</form>
				<div class="message" id="message"></div>
	</fieldset>
</center>