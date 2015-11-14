<?php if(!$data){ ?>

<form class="forgot_password form">
	<label class="label" for="email">Введите Ваш e-mail адрес</label>
	<input class="input" type="text" id="email" placeholder="email">
	<div class="error-email" style=" margin-left:400px; margin-top:-50px;"></div>
	<div class="message" style=" margin-left:50px; margin-top:-100px;"></div>
	<section class="button">
		<button type="button" id="back" onclick="clickBack()"> Назад</button>
		<button id="recover" >Восстановить</button>
	</section>
</form>

<?php }else{
	//Если параметров несколько, то делим полученную строку по параметрам (тоесть &)
	/*	
		echo "<pre>",
			var_dump($data),
			 "</pre>";
	*/
		extract($data);
		list($time, $user)= @preg_split("/\r?\n/s", $_SESSION['forgot']);
		if(@$u == $user && @$t == $time){
		$timeEnc = new Encrypt(@$t);
		$timeDec = $timeEnc->getDecrypt();
		$userEnc = new Encrypt( @$u);
		$userDec = $userEnc->getDecrypt();
		echo $userDec;
		$_SESSION['forgot_user'] = $userDec;
		$timeGet = time();
		$diffTime = Library::diffDate($timeGet, $timeDec);
			if($diffTime < 1){
				
?>
<fieldset class="change_forgot_password "  >
<legend>Изменения пароля</legend>
				<form class="form">
				<table>
					<tr>
						<td><label class="label" for="password">Пароль*</label></td>
						<td><input class="input" type="password" id="password" size="16" maxlength="128"
								   placeholder="пароль">
								   <div class="error-password"></div>
								   </td>
					</tr>
					<tr>
						<td><label class="label" for="confirmPassword">Подтверждение*</label></td>
						<td><input class="input" type="password" id="confirm" size="16" maxlength="128"
								   placeholder="подтверждение" >
								    <div class="error-confirm"></div>
								   </td>
					</tr>
				</table>
				<section class = "button">
					<button type="button" id="back" onClick="clickBack()">Назад</button>
					<button  id="change_forgot_pass"  class="reg">Восстановить</button>
				</section>
				</form>
				<div class="message" id="message"></div>
</fieldset>

<?php 
			}else{
				unset($_SESSION['forgot']);
				echo "Ссылка устарела<br>";
				echo "<a href='/'>На главную</a>";
				header( 'Refresh: 3; url=/' );
				//exit;
	  }
	  }else{
		  throw new MyExceptions('Неправильная ссылка');
	}
} ?>


