<?php
	if(isset($_SESSION["lang"])){
		$translate = new Translator($_SESSION["lang"]);
	}else{
		$translate = new Translator('ru');
	}
?>
<br>
<center><h1><?php $translate->__('Профиль')?></h1>

<? @$user =  unserialize($_SESSION["user"]) ?>

<br>

<form id="uploadForm">
	<img id="avatar" src=<?="/images/avatars/".@$user->avatar?> style="width:304px;height:300px;">
<br>
	<input name="userImage" id="userImage" type="file" />
	<input type="submit" value="Submit" />
</form>
<div class="error-avatar" style="margin-left:760px;"><?php $translate->__('Выберите файл') ?></div>
<button id="deleteAvatar" onClick="deleteAvatar()"><?php $translate->__('Удалить')?></button>

<br>

<fieldset class="profile" id="profile" >
				<form class="form">
				<table>
					<tr>
						<td><label class="label"><?php $translate->__('Логин')?></label></td>
						<td><?= @$user->login ?></td>
					</tr>
					<tr>
						<td><label class="label"><?php $translate->__('Email')?></label></td>
						<td><?= @$user->email ?></td>
					</tr>
					<tr>
						<td><label class="label" for="old"><?php $translate->__('Старый пароль')?></label></td>
						<td><input class="input" type="password" id="old" size="16" maxlength="128"
								   placeholder="<?php $translate->__('пароль')?>">
								   <div class="error-password"><?php $translate->__('Введите пароль. Не меньше 4 знаков.')?></div>
								   </td>
					</tr>
					<tr>
						<td><label class="label" for="password"><?php $translate->__('Новый пароль')?></label></td>
						<td><input class="input" type="password" id="password" size="16" maxlength="128"
								   placeholder="<?php $translate->__('новый')?>" >
								    <div class="error-password"><?php $translate->__('Введите пароль. Не меньше 4 знаков.')?></div>
								   </td>
					</tr>
					<tr>
						<td><label class="label" for="confirm"><?php $translate->__('Подтверждение пароля')?></label></td>
						<td><input class="input" type="password" id="confirm" size="16" maxlength="50"
								   placeholder="<?php $translate->__('подтверждение')?>" >
						          <div class="error-confirm"></div>
						          </td>
					</tr>
				</table>
				<section class = "button">
					<button type="button" id="back" onClick="clickBack()"><?php $translate->__('Назад')?></button>
					<button type="button" id="changePass" ><?php $translate->__('Изменить')?></button>
				</section>
				</form>
	</fieldset>
</center>