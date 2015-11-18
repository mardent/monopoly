<?php
class GameLogic {
	function xmlActionExecution($action) {
		$xml = simplexml_load_string("<a><a $action ></a></a>");
		foreach($xml->a[0]->attributes() as $a => $b) {
			switch($a) {
				//изменение положени€ на доске
				case "l" :
					echo "LOCATION 1 = $b<br>";
				break;				

				case "l2" :
					echo "LOCATION 2 = $b <br>";
				break;
				
				case "l3" :
					echo "LOCATION 3 = $b <br>";
				break;				
				
				case "l4" :
					echo "LOCATION 4 = $b <br>";
				break;				
				//давать ли деньги при пересечении финиша
				case "f" :
					echo "не давать деньги при пересечении финиша <br>";
				break;	
				//увеличивать ли плату до максимума при редиректе на некоторые компании
				case "p" :
					echo "увеличивать ли плату до максимума при редиректе на некоторые компании <br>";
				break;					
				//изменение баланса денег
				case "m" :
					echo "изменение баланса денег = $b <br>";
				break;					
				//плата денег всем\от всех игроков
				case "e" :
					echo "плата денег всем\от всех игроков = $b <br>";
				break;	
				//ремонт улиц (за дом)
				case "h" :
					echo "ремонт улиц = $b <br>";
				break;	
				//ремонт улиц (за отель)
				case "o" :
					echo "ремонт улиц = $b <br>";
				break;	
				//выход из тюрьмы
				case "n" :
					echo "выход из тюрьмы <br>";
				break;
				//отправл€йс€ в тюрьму
				case "j" :
					echo "отправл€йс€ в тюрьму <br>";
				break;
			}
		}
	}
}
?>