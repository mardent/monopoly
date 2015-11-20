<?php
if(isset($_SESSION["lang"])){
		$translate = new Translator($_SESSION["lang"]);
	}else{
		$translate = new Translator('ru');
	}
?>
  <div class="emess">
	<h1 class="er"><?php $translate->__('Ошибка 404')?></h1>
	<p class="per"><?php $translate->__('К сожалению такой странички<br/>не найдено. Администрация сайта<br/>приносит вам свои извенения.<br/>')?>
	<br />
	<br />
	<br />
	<a href="/"><?php $translate->__('Вернуться на начальную страницу')?></a>
	</p>
  </div>