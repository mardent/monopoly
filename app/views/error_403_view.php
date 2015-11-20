<?php
if(isset($_SESSION["lang"])){
		$translate = new Translator($_SESSION["lang"]);
	}else{
		$translate = new Translator('ru');
	}
?>
<div class="emess">
	<h1 class="er"><?php $translate->__('Ошибка 403')?></h1>
	<p class="per"><?php $translate->__('К сожалению у вас нет<br/>доступа к данной страничке. Для<br/>получения детальной информации<br/>обратитесь к администратору.<br/>')?>
	<br/>
	<br/>
	<a href="/"><?php $translate->__('Вернуться на начальную страницу')?></a>
	</p>
  </div>