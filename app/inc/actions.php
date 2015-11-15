<?php
	require_once '../core/user.php';
	session_start();
	require_once '../core/lib.php';
	require_once '../core/mail.php';
	require_once '../core/crypt.php';

// Конструкция для проверки авторизационных данных либо регистрации нового пользователя
	if(!empty($_POST)) {
		header("Content-type: text/txt; charset=UTF-8");
		switch($_POST["action"]) {
			case "authorization":
				$login = Library::clearStr($_POST["login"]);
				$password = Library::clearStr($_POST["password"]);
				$user = Library::getUser($login, $password);
				if ($user == null) {
					echo "<result>Неправильный логин или пароль</result>";
				} else {
					$_SESSION["user"] = serialize($user);
					echo "<result>ok</result>";
				}
				
			break;
			
			case "register":
				$login = Library::clearStr($_POST["login"]);
				$password =  Library::clearStr($_POST["password"]);
				$name = Library::clearStr($_POST["name"]);
				$email = Library::clearStr($_POST["email"]);					
				if (!Library::isLoginFree($login)) {
					echo "<result>Пользователь с таким логином уже существует</result>";
				} elseif (!Library::isMailFree($email)) {
					echo "<result>Пользователь с таким email адресом уже существует</result>";
				} else {
					Library::addUser($login, $password, $name, $email);
					echo "<result>ok</result>";
				}
			break;
			
			case "change_Password":
				$old = Library::clearStr($_POST["old"]);
				$password =  Library::clearStr($_POST["password"]);
				$confirm = Library::clearStr($_POST["confirm"]);
				if ($password != $confirm) {
					echo "<result>Пароли не совпадают</result>";
					break;
				}
				$login = unserialize($_SESSION["user"])->login;
				if (Library::changePassword($login, $old, $password)) {
					echo "<result>ok</result>";
					break;
				} else {
					echo "<result>Неверный старый пароль</result>";
					break;
				}
			break;
			
			case "change_forgot_password":
				$password =  Library::clearStr($_POST["password"]);
				$confirm = Library::clearStr($_POST["confirm"]);
				if ($password!= $confirm) {
					echo "<result>Пароли не совпадают</result>";
					break;
				}
				$login = $_SESSION['forgot_user'];
				if (Library::changeForgotPassword($login, $password)) {
					unset($_SESSION['forgot']);
					echo "<result>ok</result>";
				}else{
					echo "<result>Ошибка. Пароль не изменен</result>";
				}
			break;
		
			case "forgot":
				$email = Library::clearStr($_POST["email"]);
				$user = Library::getDataFromMail($email);
				if ($user == null) {
					echo "<result>Пользователя с таким email адресом не существует</result>";
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
						echo "<result>ok</result>";
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
			
			case "exit"; 
				unset($_SESSION["user"]);
				echo "<result>ok</result>";
			break;
			
			default:
				echo "<result>Неизвестная ошибка</result>";
	}
	
}	
?>