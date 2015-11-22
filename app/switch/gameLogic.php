<?php
class GameLogic {
	function xmlActionExecution($action) {
		$xml = simplexml_load_string("<a><a $action ></a></a>");
		foreach($xml->a[0]->attributes() as $a => $b) {
			switch($a) {
				//èçìåíåíèå ïîëîæåíèÿ íà äîñêå
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
				//äàâàòü ëè äåíüãè ïðè ïåðåñå÷åíèè ôèíèøà
				case "f" :
					echo "íå äàâàòü äåíüãè ïðè ïåðåñå÷åíèè ôèíèøà <br>";
				break;	
				//óâåëè÷èâàòü ëè ïëàòó äî ìàêñèìóìà ïðè ðåäèðåêòå íà íåêîòîðûå êîìïàíèè
				case "p" :
					echo "óâåëè÷èâàòü ëè ïëàòó äî ìàêñèìóìà ïðè ðåäèðåêòå íà íåêîòîðûå êîìïàíèè <br>";
				break;					
				//èçìåíåíèå áàëàíñà äåíåã
				case "m" :
					echo "èçìåíåíèå áàëàíñà äåíåã = $b <br>";
				break;					
				//ïëàòà äåíåã âñåì\îò âñåõ èãðîêîâ
				case "e" :
					echo "ïëàòà äåíåã âñåì\îò âñåõ èãðîêîâ = $b <br>";
				break;	
				//ðåìîíò óëèö (çà äîì)
				case "h" :
					echo "ðåìîíò óëèö = $b <br>";
				break;	
				//ðåìîíò óëèö (çà îòåëü)
				case "o" :
					echo "ðåìîíò óëèö = $b <br>";
				break;	
				//âûõîä èç òþðüìû
				case "n" :
					echo "âûõîä èç òþðüìû <br>";
				break;
				//îòïðàâëÿéñÿ â òþðüìó
				case "j" :
					echo "îòïðàâëÿéñÿ â òþðüìó <br>";
				break;
			}
		}
	}
}
?>