<?php
require_once '/../database/db.php';
require_once 'password_hash.php';
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

		//����� ������ ������������ �� ����
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
							
		//����� ������ ������������ �� ���� �� email
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
		
		
		// ������� �������� �� ����������� ������
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
		// ������� �������� �� ����������� email
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
		// ������� ��������� ������ �� ������  ����������� �� �����
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