<?php
if(isset($_SESSION["lang"])){
		$translate = new Translator($_SESSION["lang"]);
	}else{
		$translate = new Translator('ru');
	}  
?>
<body>
		<div class="wrapper">
		<!-- Шапка-->
			<div class="header">
				<a href="/" alt="Домой"><img class="home_img" src="../images/home.png"></a>
			<section class="header_button">
				<section class="button_lang">
					<button class="lang" id="english" onClick="Translator('en')"></button>
					<button class="lang" id="russian" onClick="Translator('ru')"></button>
				</section>
<?php
			if(@$_SESSION['user']){
?>
				<section class="button_for_registered">
					<button id="profile" onClick="goToProfile()"><?php $translate->__('Профиль')?></button>
					<button id="logout" onClick="Exit()"><?php $translate->__('Выход')?></button>
				<section>
<?php
			}
?>			
			</section>
			</div>
		<!-- Шапка-->
			<hr size="3">
		<!-- Основной контент-->
			<div class="content">
				 <div id="loading"></div>
				 <div class="error_message" style=" margin-left:40%; margin-top: 10px;"><?php $translate->__('Ошибка на сервере. Попробуйте еще раз') ?></div>
				 <div class="form_message" style=" margin-left:40%; margin-top: 10px;"><?php $translate->__('Внимательно заполните поля формы') ?></div>
				 <div class="message" style=" margin-left:40%; margin-top: 30px;"></div>
				<?php
					include 'app/views/'.$content_view;
				?>
			</div>
		<!-- Основной контент-->
			<hr size="3">
		<!-- Подвал-->
			<div class="footer">
			
			</div>
		<!-- Подвал-->
		</div>
	</body>
