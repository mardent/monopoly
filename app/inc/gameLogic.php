<?php
class GameLogic {
	function xmlActionExecution($action) {
		$xml = simplexml_load_string("<a><a $action ></a></a>");
		foreach($xml->a[0]->attributes() as $a => $b) {
			switch($a) {
				//��������� ��������� �� �����
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
				//������ �� ������ ��� ����������� ������
				case "f" :
					echo "�� ������ ������ ��� ����������� ������ <br>";
				break;	
				//����������� �� ����� �� ��������� ��� ��������� �� ��������� ��������
				case "p" :
					echo "����������� �� ����� �� ��������� ��� ��������� �� ��������� �������� <br>";
				break;					
				//��������� ������� �����
				case "m" :
					echo "��������� ������� ����� = $b <br>";
				break;					
				//����� ����� ����\�� ���� �������
				case "e" :
					echo "����� ����� ����\�� ���� ������� = $b <br>";
				break;	
				//������ ���� (�� ���)
				case "h" :
					echo "������ ���� = $b <br>";
				break;	
				//������ ���� (�� �����)
				case "o" :
					echo "������ ���� = $b <br>";
				break;	
				//����� �� ������
				case "n" :
					echo "����� �� ������ <br>";
				break;
				//����������� � ������
				case "j" :
					echo "����������� � ������ <br>";
				break;
			}
		}
	}
}
?>