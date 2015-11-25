<?php
require_once 'password_hash.php';
require_once '/../database/safemysql.php';
class Library {
		
		/*������� ��������� �������� ������ ���� integer*/
			public static  function clearInt($data){
				return abs((int)$data);
			}
			
		/*������� ��������� �������� ������ ���� string*/
			public static function clearStr($data){
				return addslashes(trim(strip_tags($data)));
			}
		
		//���� �� �������
			public static function getRusDate($padeg = true ,$timestamp = false){
								$rus_name = [
											'Jan' => array('������','������'),
											'Feb' => array('�������','�������'),
											'Mar' => array('����','�����'),
											'Apr' => array('������','������'),
											'May' => array('���','���'),
											'Jun' => array('����','����'),
											'Jul' => array('����','����'),
											'Aug' => array('������','�������'),
											'Sep' => array('��������','��������'),
										   'Oct' => array('�������','�������'),
										   'Nov' => array('������','������'),
										   'Dec' => array('�������','�������')
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

		//�������� ������������ � �������������� ��������
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

		//����� ������ ������������ �� ����
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
							
		//����� ������ ������������ �� ���� �� email
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
			
		
		// ������� �������� �� ����������� ������
				public static function isLoginFree($login) {
								$db = new SafeMySQL();
								if(!$result = $db->getRow("SELECT * FROM USERS WHERE LOGIN = ?s", $login))
									return true;
								return false;
							}
							
		// ������� �������� �� ����������� email
				public static function isMailFree($email) {
								$db = new SafeMySQL();
								if(!$result = $db->getRow("SELECT * FROM USERS WHERE EMAIL = ?s", $email))
									return true;
								return false;
							}
							
		//������� �������� ����  � ������������� ������ ������� ���������� � ���������� � ��������� ���� ���������� ����
					public static function fillVars($filename, $vars){
							ob_start();
							extract($vars, EXTR_OVERWRITE);
							include "$filename";
							$text = ob_get_contents();
							ob_end_clean();
							return $text;
					}
		//��������� ������ �� �������� ������� ������������
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
		// ������� ��������� ������ �� ������  ����������� �� �����
					public static function changeForgotPassword($login, $password) {
								$db = new SafeMySQL();
								if(!$result = $db->getRow("SELECT * FROM USERS WHERE LOGIN = ?s", $login))
									return false;
									$solt = Password::createSalt();
									$passCrypt = Password::create_hash($password, $solt);
									$db->query("UPDATE USERS SET PASSWORD = ?s, SOLT = ?s WHERE LOGIN = ?s", $passCrypt, $solt, $login);
								return true;
						}
		
		// ������� ������� ���� ��������� �����
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