<?php
	require_once '../core/user.php';
	session_start();
	require_once '../core/lib.php';
	require_once '../core/mail.php';
	require_once '../core/crypt.php';
	require_once '../core/translation.php';
	if(isset($_SESSION["lang"])){
		$translate = new Translator($_SESSION["lang"], '../../lang/');
	}else{
		$translate = new Translator('en', '../../lang/');
	} 
// Конструкция для проверки авторизационных данных либо регистрации нового пользователя
	if(!empty($_POST)) {
		header("Content-type: text/txt; charset=UTF-8");
		switch($_POST["action"]) {
			case "authorization":
				$login = Library::clearStr($_POST["login"]);
				$password = Library::clearStr($_POST["password"]);
				$user = Library::getUser($login, $password);
				if ($user == null) {
					$translate->TransForScript("Неправильный логин или пароль");
				} else {
					$_SESSION["user"] = serialize($user);
					$translate->TransForScript("ок", "success");

				}
				
			break;
			
			case "register":
				$login = Library::clearStr($_POST["login"]);
				$password =  Library::clearStr($_POST["password"]);
				$name = Library::clearStr($_POST["name"]);
				$email = Library::clearStr($_POST["email"]);					
				$captcha_input = isset($_POST['captcha']) ? (string) $_POST['captcha'] : '';
				error_log("Err".$captcha_input, 0);
				$captcha_session = isset($_SESSION['captcha_session']) ? (string) $_SESSION['captcha_session'] : '';
				error_log("Err".$captcha_session, 0);
				if ( empty($captcha_input) ) {
				} elseif ( empty($captcha_session) ) {
				} elseif ( $captcha_input != $captcha_session ) {
					$translate->TransForScript("Вы ввели неправильную капчу");
				} elseif (!Library::isLoginFree($login)) {
					$translate->TransForScript("Пользователь с таким логином уже существует");
				} elseif (!Library::isMailFree($email)) {
					$translate->TransForScript("Пользователь с таким email адресом уже существует");
				} else {
					Library::addUser($login, $password, $name, $email);
					$translate->TransForScript("Поздравляем. Вы успешно зарегистрированы!", "success");
				}
			break;
			
			case "change_Password":
				$old = Library::clearStr($_POST["old"]);
				$password =  Library::clearStr($_POST["password"]);
				$confirm = Library::clearStr($_POST["confirm"]);
				if ($password != $confirm) {
					$translate->TransForScript("Пароли не совпадают");
					break;
				}
				$login = unserialize($_SESSION["user"])->login;
				if (Library::changePassword($login, $old, $password)) {
					$translate->TransForScript("Пароль успешно изменен", "success");
					break;
				} else {
					$translate->TransForScript("Неверный старый пароль");
					break;
				}
			break;
			
			case "change_forgot_password":
				$password =  Library::clearStr($_POST["password"]);
				$confirm = Library::clearStr($_POST["confirm"]);
				if ($password!= $confirm) {
					$translate->TransForScript("Пароли не совпадают");
					break;
				}
				$login = $_SESSION['forgot_user'];
				if (Library::changeForgotPassword($login, $password)) {
					unset($_SESSION['forgot']);
					$translate->TransForScript("Пароль успешно изменен. Вы будете пренаправлены на страницу входа", "success");
				}else{
					$translate->TransForScript("Ошибка. Пароль не изменен");
				}
			break;
		
			case "forgot":
				$email = Library::clearStr($_POST["email"]);
				$user = Library::getDataFromMail($email);
				if ($user == null) {
					$translate->TransForScript("Пользователя с таким email адресом не существует");
				} else {
					$separator = getenv('COMSPEC')? "\r\n" : "\n";
					$time = time();
					$time = new Encrypt($time);
					$timeEnc = $time->getEncrypt();
					$data = $timeEnc.$separator;
					$userId = new Encrypt($user->login);
					$userEnc = $userId->getEncrypt();
					$data .= $userEnc;
					$_SESSION["forgot"] = $data;
					$to = $user->email;
					$href = "<a href=http://".$_SERVER['HTTP_HOST']."/forgot_password/recover?u=".$userEnc."&t=".$timeEnc.">Восстановить</a>";
					$newMail = new Mail();
					$mail = Library::fillVars("mail.eml", array(
						"to" => $to,
						"href" => $href,
					));
					if(!$newMail->mail_encoding($mail))
						return false;
					if(!$newMail->sendMail($mail))
						return false;
						$translate->TransForScript("Вам на почту отправлены дальнейшие инструкции", "success");
					}		
		   	break;
			
			case "deleteAvatar":
				$user = unserialize($_SESSION["user"]);
				$fileName = "Noavatar.png";
				if ($user->avatar != 'Noavatar.png')
					unlink("../../images/avatars/".$user->avatar);
				Library::changeAvatar($user->login, $fileName);
				$user->avatar = $fileName;
				$_SESSION["user"] = serialize($user);
				echo "<result>$fileName</result>";
			break;
			
			case "exit": 
				unset($_SESSION["user"]);
				$translate->TransForScript("Досвидания", "success");
			break;

			case "lang": 
				$lang = Library::clearStr($_POST["lang"]);
				$_SESSION["lang"] = $lang;
				$translate->TransForScript("ок", "success");
			break;
			
			default:
				$translate->TransForScript("Неизвестная ошибка");
	}
	
}	
?>