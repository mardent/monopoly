<body>
		<div class="wrapper">
		<!-- Шапка-->
			<div class="header">
				<a href="/" alt="Домой"><img class="home_img" src="../images/home.png"></a>
<?php
			if(@$_SESSION['user']){
			echo <<<VISIBLE
				<section class="button_for_registered">
					<button id="profile" onClick="goToProfile()">Профиль</button>
					<button id="logout" onClick="Exit()">Выход</button>
				<section>
VISIBLE;
			}
?>
			</div>
		<!-- Шапка-->
			<hr size="3">
		<!-- Основной контент-->
			<div class="content">
				 <div id="loading"></div>
				<?php
				/*
					ECHO "<pre>",
						var_dump($_SERVER),
						"</pre>";
				*/
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
