<?php

	require_once 'lib.php';
	require_once 'db.php';
	require_once 'safemysql.php';
	
	define('SEMKEY', 1000);
	
	//private function deleteRoom($roomID) {};
	//public function createRoom($name, $pass = false, $players, $money, $time) {};
	
	if(!empty($_POST)) {
		header("Content-type: text/txt; charset=UTF-8");
		switch($_POST["action"]) {
			case "createRoom":
				$name = Library::clearStr($_POST["name"]);
				//error_log("Err".$name, 0);
				$password = Library::clearStr($_POST["password"]);
				$players = Library::clearStr($_POST["players"]);
				$money = Library::clearStr($_POST["money"]);
				$time = Library::clearStr($_POST["time"]);
				
				$lib = new LibraryForGame;				
				$sem_id = $lib -> sem_get($SEMKEY);
				if($sem_id === false)
				{
					exit;
				}
				if(!$lib -> sem_acquire($sem_id))
				{
				//	echo "<result>Ошибка при попытке занять семафор.\n</result>";
					exit;
				}else{
				//	echo "<result>Семафор успешно занят</result>";
					
					if ($lib -> isNameFree($name)){
						$lib -> createRoom ($name, $password, $players, $money, $time);
						$maxId = $lib -> LastID ();
						//error_log("Err".$maxId, 0);
						$user_id = 5; //должен получать значение из сесии
						$lib -> addFirstPlayer ($user_id, $maxId);
						echo "<result>ok</result>";
						//echo "<result>Вы создали новую комнату</result>";
					}else{
						echo "<result>Комната с таким именем уже создана</result>";
					}
					if (!$lib -> sem_release($sem_id)) {
					//	echo "Ошибка при попытке освободить семафор.\n";
					}else{
					//	echo "Семафор освобожден.\n";
					}
				}
			break;
			
			case "exit"; 
				unset($_SESSION["user"]);
				echo "<result>ok</result>";
			break;
			
			default:
				echo "<result>Неизвестная ошибка</result>";
		}
	}
	
	
	class LibraryForGame {
		
		public $CommunityChest_arr;
		public $Chance_arr;
	
		public function createRoom ($name, $password = false, $players, $money, $time) {
			$db = new SafeMySQL();
			$password = md5 ($password);
			$sql = "INSERT INTO ROOMS (NAME, PASSWORD, NUM_PLAYERS, INITIAL_MONEY, TURN_TIME) VALUES (?s, ?s, ?s, ?s, ?s)";
			$db -> query($sql, $name, $password, $players, $money, $time);
			return true;
		}
			
		public function LastID () {
			$db = new SafeMySQL();
			$maxId_arr =($db->getCol("SELECT MAX(ID) FROM ROOMS"));
			$maxId = $maxId_arr[0];
			return $maxId;
		}
		
		public function addFirstPlayer ($user_id, $maxId, $password = false) {
			$db = new SafeMySQL();
			$sql = "INSERT INTO PLAYERS (USER_ID, ROOM_ID) VALUES (?i, ?i)";
			$db -> query($sql, $user_id, $maxId);
			return true;
		}
	
		
		public function deleteRoom ($roomID) {
			$db = new SafeMySQL();
			if ($this -> isRoomEmpty ($roomID)) {
				$sql = "DELETE FROM ROOMS WHERE ID = ?i";
				$db -> query($sql, $roomID);
				return true;
			}else{
				return false;
			}
		}
		
		
		//Функция проверки уникальности имени комнаты
		public function isNameFree($name) {
			$db = new SafeMySQL();
			$name = $db->getOne("SELECT * FROM ROOMS WHERE name=?s", $name);
			if (!$name){
				return true;
			}else{
				return false;
			}
		}
		
		
		//Функция для проверки заполнена ли полностью комната
		//private function isRoomReady($roomID) {}
		//private function isRoomEmpty($roomID) {}
		public function isRoomReady($roomID) {
			$db = new SafeMySQL();
			$sql = "SELECT COUNT(*) FROM PLAYERS WHERE ROOM_ID = ?i";
			$count = $db -> getOne($sql, $roomID);
			$sql = "SELECT NUM_PLAYERS FROM ROOMS WHERE ID = ?i";
			$num_players = $db -> getOne($sql, $roomID);
			if ($count == $num_players) {
				echo "Комната полностью заполнена";
				return true;
			}else{
				echo "Вы можете подключиться";
				return false;
			}
		}
		
		public function isRoomEmpty ($roomID) {
			$db = new SafeMySQL();
			$sql = "SELECT COUNT(*) FROM PLAYERS WHERE ROOM_ID = ?i";
			$count = $db -> getOne($sql, $roomID);
			if ($count == 0) {
				echo "Комната пуста";
				return true;
			}else{
				echo "Комната не пуста";
				return false;
			}
		}
		
		//Функции для добавления/удаления игроков из комнаты
		//public function addPlayer($roomID, $userID, $password = false) {}
		//public function removePlayer($userID) {}
		
		//как реализовать получение параметров функции?
		public function addPlayer($userID, $roomID, $password = false) {
			$db = new SafeMySQL();
			if ($password) {
				$password = md5 ($password);
				$sql = "SELECT PASSWORD FROM ROOMS WHERE ID = ?i";
				$pass_room = $db -> getOne($sql, $roomID);
				if ($password == $pass_room) {
					$sql = "INSERT INTO PLAYERS (USER_ID, ROOM_ID) VALUES (?i, ?i)";
					$db -> query($sql, $userID, $roomID);
					return true;
				}else{
					echo "Введен неверный пароль";
					return false;
				}
			}else{
				$sql = "INSERT INTO PLAYERS (USER_ID, ROOM_ID) VALUES (?i, ?i)";
				$db -> query($sql, $userID, $roomID);
				return true;
			}
		}
		
		public function removePlayer($userID) {
			$db = new SafeMySQL();
			$sql = "DELETE * FROM PLAYERS WHERE USER_ID = ?i";
			$db -> query($sql, $userID);
			echo "Игрок был удален из комнаты";
			return true;
		}
		
		
		//Функция для генерации порядка карточек
		//Количество карточек в базе данных можно менять на работу это не повлияет
		//private function generateGameCardsOrder(){}
		public function generateGameCardsOrder_CommunityChest () {
			$db = new SafeMySQL();
			$num_arr = array();
			$sql = "SELECT COUNT(*) FROM INFO_CARDS WHERE TYPE_NAME = ?s";
			$type_name = "Community Chest";
			$count = $db -> getOne($sql, $type_name);
			$j = $count;
			//echo $j;
			for ($i = 1; $i <= $j; $i++) {
				$num = mt_rand(1, $count);
				//echo "$num.\n";
				if (count($num_arr) == 0){
				$num_arr[] = $num;
				//print_r ($num_arr);
				}else{
					if ($this -> prov_arr ($num_arr, $num) == true) {
						$num_arr[] = $num;
						//print_r ($num_arr);
					}else{
						$j++;
					}
				}
				if (count($num_arr) == $count) {
					//print_r ($num_arr);
					$this -> CommunityChest_arr = $num_arr;
					return $num_arr;
				}
			}
		}
		
		
		public function generateGameCardsOrder_Chance	() {
			$db = new SafeMySQL();
			$num_arr = array();
			$sql = "SELECT COUNT(*) FROM INFO_CARDS WHERE TYPE_NAME = ?s";
			$type_name = "Community Chest";
			$count_chest = $db -> getOne($sql, $type_name);
			$sql = "SELECT COUNT(*) FROM INFO_CARDS WHERE TYPE_NAME = ?s";
			$type_name = "Chance";
			$count_chance = $db -> getOne($sql, $type_name);
			$j = $count_chance;
			//echo $j;
			for ($i = 1; $i <= $j; $i++) {
				$num = mt_rand($count_chest+1, $count_chest+$count_chance);
				//echo "$num.\n";
				if (count($num_arr) == 0){
				$num_arr[] = $num;
				//print_r ($num_arr);
				}else{
					if ($this -> prov_arr ($num_arr, $num) == true) {
						$num_arr[] = $num;
						//print_r ($num_arr);
					}else{
						$j++;
					}
				}
				if (count($num_arr) == $count_chance) {
					//print_r ($num_arr);
					$this -> Chance_arr = $num_arr;
					return $num_arr;
				}
			}
		}
		
		
		public function prov_arr ($num_arr, $num) {
			for ($i = 0; $i <= count($num_arr)-1; $i++) {
				if ($num_arr[$i] == $num) {
					//echo "такой элемент уже есть";
					return false;
				}
			}
			return true;
		}
		
		
		//Функция генерации броска
		public function generateThrow () {
			$num = mt_rand (2, 12);
			return $num;
			//echo $num;
		}
		
		
		//Функция генерации порядка хода игроков
		//На выходе массив с порядком ходов
		//private function setPlayersOrder(){}
		public function setPlayersOrder ($roomID) {
			$db = new SafeMySQL();
			$sql = "SELECT ID FROM PLAYERS WHERE ROOM_ID = ?i";
			$count = $db -> getCol($sql, $roomID);
			shuffle ($count);
			//print_r ($count);
			return $count;
		}
		
		//Функция для извлечения информационной карточки
		//public function getInfoCard ($type) {}
		public function getInfoCard ($type) {
			if ($type == "Community Chest") {
				$info_card = $this -> CommunityChest_arr;
				$value = array_shift($info_card);
				$info_card [] = $value;
				$this -> CommunityChest_arr = $info_card;
			}else{
				$info_card = $this -> Chance_arr;
				$value = array_shift($info_card);
				$info_card [] = $value;
				$this -> Chance_arr = $info_card;
			}
			return $value;
		}
		
		
		//Функции для работы с семафором
		public function sem_get($key) {
			return fopen(__FILE__ . '.sem.' . $key, 'w+');
		}
		
		public function sem_acquire($sem_id) {
			return flock($sem_id, LOCK_EX);
		}
		
		public function sem_release($sem_id) {
			return flock($sem_id, LOCK_UN);
		}

	}	
		
