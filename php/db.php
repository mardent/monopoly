<?php
	class DataBase {
		const DB_HOST = 'localhost';
		const DB_LOGIN = 'root';
		const DB_PASS = '';
		const DB_NAME = 'WEBDEV_DB';
		public static $dbConnect;
		public static function Connect (){
				self::$dbConnect = mysqli_connect(self::DB_HOST, self::DB_LOGIN, self::DB_PASS, self::DB_NAME);
				
				if(!self::$dbConnect){
						echo "<p><b>Ошибка соединения с базой".mysqli_connect_error()."</b></p>";
						exit();
						return false;
				}
				return self::$dbConnect;
		}
		
		public static function Close(){
			
			return mysqli_close(self::$dbConnect);
		}
	}
?>