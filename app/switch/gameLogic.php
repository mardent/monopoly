<?php
class GameLogic {
	function xmlActionExecution($action) {
		$xml = simplexml_load_string("<a><a $action ></a></a>");
		foreach($xml->a[0]->attributes() as $a => $b) {
			switch($a) {
				//location changing on the board
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
				//is money gives if "Go" is crossed
				case "f" :
					echo "don't give money if "Go" is crossed <br>";
				break;	
				//duplex pay for transport companies and 10x for water\electrycity
				case "p" :
					echo "duplex pay for transport companies and 10x for water\electrycity <br>";
				break;					
				//changing money balance
				case "m" :
					echo "changing money balance on = $b <br>";
				break;					
				//paying to\from all players
				case "e" :
					echo "paying to\from all players = $b <br>";
				break;	
				//homes repeiring
				case "h" :
					echo "homes repeiring = $b <br>";
				break;	
				//hotels repearing
				case "o" :
					echo "hotels repearing = $b <br>";
				break;	
				//free jail lefting
				case "n" :
					echo "free jail lefting <br>";
				break;
				//got to jail
				case "j" :
					echo "got to jail <br>";
				break;
			}
		}
	}
}
?>
