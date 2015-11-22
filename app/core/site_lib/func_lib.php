<?php
require_once '/../database/db.php';
require_once 'password_hash.php';
class Library {
		
		/*Функция обработки принятых данных типа integer*/
			public static  function clearInt($data){
				return abs((int)$data);
			}
			
		/*Функция обработки принятых данных типа string*/
			public static function clearStr($data){
				return addslashes(trim(strip_tags($data)));
			}
		
		//Дата на русском
			public static function getRusDate($padeg = true ,$timestamp = false){
								$rus_name = [
											'Jan' => array('Январь','Января'),
											'Feb' => array('Февраль','Февраля'),
											'Mar' => array('Март','Марта'),
											'Apr' => array('Апрель','Апреля'),
											'May' => array('Май','Мая'),
											'Jun' => array('Июнь','Июня'),
											'Jul' => array('Июль','Июля'),
											'Aug' => array('Август','Августа'),
											'Sep' => array('Сентябрь','Сентября'),
										   'Oct' => array('Октябрь','Октября'),
										   'Nov' => array('Ноябрь','Ноября'),
										   'Dec' => array('Декабрь','Декабря')
										];
							if(!$timestamp){
								$year = date('Y');
								$month =  date('M');
								$day = date('d');
							}else{
								$year = date('Y',$timestamp);
								$month =  date('M', $timestamp);
								$day = date('d', $timestamp);
							}
							if($padeg)
								$res = $day." ".$rus_name[$month][1]." ".$year;
							else
								$res = $day." ".$rus_name[$month][0]." ".$year;
							return $res;
						}

		//Создание пользователя с подготовленным запросом
				public static function addUser($login, $password, $name, $email) {
								$solt = Password::createSalt();
								$passCrypt = Password::create_hash($password, $solt);
								$stmt = mysqli_stmt_init(DataBase::Connect());
								$query = "INSERT INTO USERS (LOGIN,
															PASSWORD,
															NAME,
															EMAIL,
															SOLT)
												VALUES (?,?,?,?,?)";	
								if(!mysqli_stmt_prepare($stmt,$query))
								return false;
								mysqli_stmt_bind_param ($stmt, "sssss" ,$login, $passCrypt, $name, $email, $solt);	
								mysqli_stmt_execute($stmt);
								mysqli_stmt_close($stmt);
								return true;
							}

		//Вывод данных пользователя из базы
				public static function getUser($login, $password) {
								$query = sprintf("SELECT * FROM USERS WHERE LOGIN = '%s'", 
									mysqli_real_escape_string(DataBase::Connect(), $login));
								if(!$result = mysqli_query(DataBase::Connect(), $query)){
									mysqli_free_result($result);
									DataBase::Close();
									return false;
								}
								if (mysqli_num_rows($result) != 0) {
									$row = mysqli_fetch_array ($result);
									$solt = $row["SOLT"];
									$passDb = $row["PASSWORD"];
									if(!Password::validate_password($password, $passDb, $solt))
										return false;
									$user = new User(
													$row["LOGIN"],
													$row["PASSWORD"],
													$row["NAME"],
													$row["EMAIL"],
													$row["AVATAR_URL"]);
								}
								mysqli_free_result($result);
								DataBase::Close();
								return $user;
							}
							
		//Вывод данных пользователя из базы по email
				public static function getDataFromMail($email) {
								$query = sprintf("SELECT * FROM USERS WHERE EMAIL = '%s'", 
									mysqli_real_escape_string(DataBase::Connect(), $email));
								if(!$result = mysqli_query(DataBase::Connect(), $query)){
									mysqli_free_result($result);
									DataBase::Close();
									return false;
								}
								if (mysqli_num_rows($result) != 0) {
									$row = mysqli_fetch_array ($result);
									$user = new User(
													$row["LOGIN"],
													$row["PASSWORD"],
													$row["NAME"],
													$row["EMAIL"],
													$row["AVATAR_URL"]);
								}
								mysqli_free_result($result);
								DataBase::Close();
								return $user;
							}
		
		
		// Функция проверки на доступность логина
				public static function isLoginFree($login) {
								$query = sprintf("SELECT * FROM USERS WHERE LOGIN = '%s'",
											mysqli_real_escape_string(DataBase::Connect(), $login));
								if(!$result = mysqli_query(DataBase::Connect(), $query)){
									DataBase::Close();
									return false;		
								}else if(mysqli_num_rows($result) === 0){
									DataBase::Close();
									return true;
								}else{
									return false;
								}
							}
		// Функция проверки на доступность email
				public static function isMailFree($email) {
								$query = sprintf("SELECT * FROM USERS WHERE EMAIL = '%s'",
											mysqli_real_escape_string(DataBase::Connect(), $email));
								if(!$result = mysqli_query(DataBase::Connect(), $query)){
									DataBase::Close();
									return false;		
								}else if(mysqli_num_rows($result) === 0){
									DataBase::Close();
									return true;
								}else{
									return false;
								}
							}
		//Функция получает файл  и ассоциативный массив который превращает в переменные и заполняет ними полученный файл
					public static function fillVars($filename, $vars){
							ob_start();
							extract($vars, EXTR_OVERWRITE);
							include "$filename";
							$text = ob_get_contents();
							ob_end_clean();
							return $text;
					}
		//Изменение пароля со страницы профиля пользователя
		public static function changePassword($login, $oldPass, $newPass) {
				$query = sprintf("SELECT * FROM USERS WHERE LOGIN = '%s'", 
					mysqli_real_escape_string(DataBase::Connect(), $login));
				if(!$result = mysqli_query(DataBase::Connect(), $query)){
					mysqli_free_result($result);
					DataBase::Close();
					return false;
				}
				if (mysqli_num_rows($result) != 0) {
					$row = mysqli_fetch_array ($result);
					$solt = $row["SOLT"];
					$passDb = $row["PASSWORD"];
					if(!Password::validate_password($oldPass, $passDb, $solt)){
						return false;
					} else {
						$solt = Password::createSalt();
						$passCrypt = Password::create_hash($newPass, $solt);
						$stmt = mysqli_stmt_init(DataBase::Connect());
						$query = "UPDATE USERS SET PASSWORD = ?, SOLT = ? WHERE LOGIN = ?";	
						if(!mysqli_stmt_prepare($stmt, $query))
							return false;
						mysqli_stmt_bind_param ($stmt, "sss", $passCrypt, $solt, $login);	
						mysqli_stmt_execute($stmt);
						mysqli_stmt_close($stmt);
					}
				}
			mysqli_free_result($result);
			DataBase::Close();
			return true;
		}
		// Функция изменения пароля по токену  полученному на почту
		public static function changeForgotPassword($login, $password) {
				$query = sprintf("SELECT * FROM USERS WHERE LOGIN = '%s'", 
					mysqli_real_escape_string(DataBase::Connect(), $login));
				if(!$result = mysqli_query(DataBase::Connect(), $query)){
					mysqli_free_result($result);
					DataBase::Close();
					return false;
				}
				if (mysqli_num_rows($result) != 0){
						$solt = Password::createSalt();
						$passCrypt = Password::create_hash($password, $solt);
						$stmt = mysqli_stmt_init(DataBase::Connect());
						$query = "UPDATE USERS SET PASSWORD = ?, SOLT = ? WHERE LOGIN = ?";	
						if(!mysqli_stmt_prepare($stmt, $query))
							return false;
						mysqli_stmt_bind_param ($stmt, "sss", $passCrypt, $solt, $login);	
						mysqli_stmt_execute($stmt);
						mysqli_stmt_close($stmt);
					}
			mysqli_free_result($result);
			DataBase::Close();
			return true;
		}
		
		// Функция разницы Двух временных меток
		public static function diffDate ($dateBig, $dateSmall){
			if($dateBig > $dateSmall){
				$diff = date('d', $dateBig) - date('d', $dateSmall);
			}else{
				$diff = date('d', $dateSmall) - date('d', $dateBig);
			}
			return $diff;
		}
		
		//Avarar updating
		public static function changeAvatar($login, $avatar) {
			$stmt = mysqli_stmt_init(DataBase::Connect());
			$query = "UPDATE USERS SET AVATAR_URL = ? WHERE LOGIN = ?";
			if(!mysqli_stmt_prepare($stmt, $query))
				return false;
			mysqli_stmt_bind_param($stmt, "ss", $avatar, $login);	
			mysqli_stmt_execute($stmt);
			mysqli_stmt_close($stmt);
			return true;
		}
}

?>