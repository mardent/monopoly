<?php 
	if(isset($_SESSION["lang"])){
		$translate = new Translator($_SESSION["lang"]);
	}else{
		$translate = new Translator('ru');
	}
?>
<table class="cabinets_table" border="1">
	<tr class="first_row">
		<th><?php $translate->__('Имя')?></th>
		<th><?php $translate->__('Пароль')?></th>
		<th><?php $translate->__('Игроки')?></th>
		<th><?php $translate->__('Время хода')?></th>
		<th><?php $translate->__('Стартовый капитал')?></th>
	</tr>
	<tr>
		<td>Test_1</td>
		<td>****</td>
		<td>4/5</td>
		<td>30c</td>
		<td>500$</td>
	</tr>
	<tr>
		<td>Test_2</td>
		<td>****</td>
		<td>5/5</td>
		<td>30c</td>
		<td>200$</td>
	</tr>	
	<tr>
		<td>Test_3</td>
		<td>****</td>
		<td>2/4</td>
		<td>30c</td>
		<td>600$</td>
	</tr>
<?php
	/*foreach ($data as $row){
		echo '<tr><td>'.$row[''].'</td><td>'.$row[''].'</td><td>'.$row[''].'</td><td>'.$row[''].'</td><td>'.$row[''].'</td></tr>';
	}*/
?>
</table>
<section class="cabinet_button">
	<button id="back" onClick=""><?php $translate->__('Войти')?></button>
	<button id="create" onClick=""><?php $translate->__('Создать')?></button>
	<button id="refresh" onClick=""><?php $translate->__('Обновить')?></button>
<section>












