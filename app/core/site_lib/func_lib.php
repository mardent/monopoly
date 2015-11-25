<?php
require_once 'password_hash.php';
require_once '/../database/safemysql.php';
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
								$db = new SafeMySQL();
								$data = $db->query("INSERT INTO USERS (LOGIN,
															PASSWORD,
															NAME,
															EMAIL,
															SOLT)
												VALUES (?s,?s,?s,?s,?s)",$login, $passCrypt, $name, $email, $solt);
								}

		//Вывод данных пользователя из базы
				public static function getUser($login, $password) {
								$db = new SafeMySQL();
								if(!$result = $db->getRow("SELECT * FROM USERS WHERE LOGIN = ?s", $login)){
									return false;
								}
									$solt = $result["SOLT"];
									$passDb = $result["PASSWORD"];
									if(!Password::validate_password($password, $passDb, $solt))
										return false;
									$user = new User(
													$result["LOGIN"],
													$result["PASSWORD"],
													$result["NAME"],
													$result["EMAIL"],
													$result["AVATAR_URL"]);
									return $user;
							}
							
		//Вывод данных пользователя из базы по email
					public static function getDataFromMail($email) {
									$db = new SafeMySQL();
									if(!$result = $db->getRow("SELECT * FROM USERS WHERE EMAIL = ?s", $email)){
										return false;
									}
									$user = new User(
													$result["LOGIN"],
													$result["PASSWORD"],
													$result["NAME"],
													$result["EMAIL"],
													$result["AVATAR_URL"]);
									return $user;
								}
			
		
		// Функция проверки на доступность логина
				public static function isLoginFree($login) {
								$db = new SafeMySQL();
								if(!$result = $db->getRow("SELECT * FROM USERS WHERE LOGIN = ?s", $login))
									return true;
								return false;
							}
							
		// Функция проверки на доступность email
				public static function isMailFree($email) {
								$db = new SafeMySQL();
								if(!$result = $db->getRow("SELECT * FROM USERS WHERE EMAIL = ?s", $email))
									return true;
								return false;
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
								$db = new SafeMySQL();
								if(!$result = $db->getRow("SELECT * FROM USERS WHERE LOGIN = ?s", $login))
									return false;
								$solt = $result["SOLT"];
								$passDb = $result["PASSWORD"];
								if(!Password::validate_password($oldPass, $passDb, $solt)){
									return false;
								} else {
									$solt = Password::createSalt();
									$passCrypt = Password::create_hash($newPass, $solt);
									$db->query("UPDATE USERS SET PASSWORD = ?s, SOLT = ?s WHERE LOGIN = ?s", $passCrypt, $solt, $login);
								}
								return true;
					}
		// Функция изменения пароля по токену  полученному на почту
					public static function changeForgotPassword($login, $password) {
								$db = new SafeMySQL();
								if(!$result = $db->getRow("SELECT * FROM USERS WHERE LOGIN = ?s", $login))
									return false;
									$solt = Password::createSalt();
									$passCrypt = Password::create_hash($password, $solt);
									$db->query("UPDATE USERS SET PASSWORD = ?s, SOLT = ?s WHERE LOGIN = ?s", $passCrypt, $solt, $login);
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
						$db = new SafeMySQL();
						$db->query("UPDATE USERS SET AVATAR_URL = ?s WHERE LOGIN = ?s", $avatar, $login);
						return true;
					}
}

?>