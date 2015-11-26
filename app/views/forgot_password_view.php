<?php 
	if(isset($_SESSION["lang"])){
		$translate = new Translator($_SESSION["lang"]);
	}else{
		$translate = new Translator('ru');
	}
if(!$data){ ?>

<form class="forgot_password form">
	<label class="label" for="email"><?php $translate->__('Введите Ваш e-mail адрес')?></label>
	<input class="input" type="text" id="email" placeholder="email">
	<div class="error-email" style=" margin-left:400px; margin-top:-50px;"><?php $translate->__('Ссылка не действительна')?></div>
	<section class="button">
		<button type="button" id="back" onclick="clickBack()"><?php $translate->__('Назад')?></button>
		<button id="recover" ><?php $translate->__('Восстановить')?></button>
	</section>
</form>

<?php }else{
	//Если параметров несколько, то делим полученную строку по параметрам (тоесть &)
		extract($data);
		@list($time, $user)= @preg_split("/\r?\n/s", @$_SESSION['forgot']);
		if(@$u == $user && @$t == $time){
		$timeEnc = new Encrypt(@$t);
		$timeDec = $timeEnc->getDecrypt();
		$userEnc = new Encrypt( @$u);
		$userDec = $userEnc->getDecrypt();
		$_SESSION['forgot_user'] = $userDec;
		$timeGet = time();
		$diffTime = Library::diffDate($timeGet, $timeDec);
			if($diffTime < 1){
				
?>
<fieldset class="change_forgot_password "  >
<legend><?php $translate->__('Изменения пароля')?></legend>
				<form class="form">
				<table>
					<tr>
						<td><label class="label" for="password"><?php $translate->__('Пароль*')?></label></td>
						<td><input class="input" type="password" id="password" size="16" maxlength="128"
								   placeholder="<?php $translate->__('пароль')?>">
								   <div class="error-password"><?php $translate->__('Введите пароль. Не меньше 4 знаков.')?></div>
								   </td>
					</tr>
					<tr>
						<td><label class="label" for="confirmPassword"><?php $translate->__('Подтверждение*')?></label></td>
						<td><input class="input" type="password" id="confirm" size="16" maxlength="128"
								   placeholder="<?php $translate->__('подтверждение')?>" >
								    <div class="error-confirm"></div>
								   </td>
					</tr>
				</table>
				<section class = "button">
					<button type="button" id="back" onClick="clickBack()"><?php $translate->__('Назад')?></button>
					<button  id="change_forgot_pass"  class="reg"><?php $translate->__('Восстановить')?></button>
				</section>
				</form>
</fieldset>

<?php 
			}else{
				unset($_SESSION['forgot']);
				echo "<?php $translate->__('Ссылка устарела<br>')?>";
				echo "<a href='/'><?php $translate->__('На главную')?></a>";
				header( 'Refresh: 3; url=/' );
				//exit;
	  }
	  }else{
		  throw new MyExceptions('Неправильная ссылка');
	}
} ?>


