
/*--------------------------------Бибиотека функций начало блока-----------------------------------*/
function clickBack() {
	document.location.href ='/';
}

function sendRegData(login, password, name, email, captcha){
	    $.ajax({
		dataType: "xml",
        url: "/app/switch/site_actions.php",
        type: "POST",
        data: {
            action : "register",
            login : login,
            password : password,
			name : name,
			email : email,
			captcha : captcha
        },
        success: function (data) {
            if ($(data).find("success").text()) {
				$('.input').val('').removeAttr('style');
				$('#loading').css('display','none');
				var text = $(data).find("success").text();
				$('.message').html(text).fadeIn(200, function(){ $(this).css('display','block')}).fadeOut(6000, function(){ $(this).css('display','none')});
            } else {
				$('#password, #confirm').val('').removeAttr('style');
				document.getElementById('captcha_image').src='app/inc/captcha.php?'+Math.random();
				$('#loading').css('display','none');
                var text = $(data).find("result").text();
				$('.message').html(text).fadeIn(200, function(){ $(this).css('display','block')}).fadeOut(6000, function(){ $(this).css('display','none')});
            }
        },
        error: function () {
			$('.input').val('').removeAttr('style');
			$('#loading').css('display','none');
            $('.error_message').fadeIn(200, function(){ $(this).css('display','block')}).fadeOut(6000, function(){ $(this).css('display','none')});
        }
    });
}

function login(login, password) {
    $.ajax({
		dataType: "xml",
        url: "/app/switch/site_actions.php",
        type: "POST",
        data: {
            action: "authorization",
            login: login,
            password: password
        },
        success: function (data) {
            if ("ок" === $(data).find("success").text().toLowerCase()) {
                location.replace("/cabinet");
				$('.input').val('').removeAttr('style');
				$('#loading').css('display','none');
            } else {
				$('.input').val('').removeAttr('style');
				$('#loading').css('display','none');
                var text = $(data).find("result").text();
				$('.message').html(text).fadeIn(200, function(){ $(this).css('display','block')}).fadeOut(6000, function(){ $(this).css('display','none')});
            }
        },
        error: function () {
		   $('.input').val('').removeAttr('style');
		   $('#loading').css('display','none');
           $('.error_message').fadeIn(200, function(){ $(this).css('display','block')}).fadeOut(6000, function(){ $(this).css('display','none')});
        }
   });
}


function forgotPass(email) {
    $.ajax({
		dataType: "xml",
        url: "/app/switch/site_actions.php",
        type: "POST",
        data: {
            action: "forgot",
			email: email
        },
        success: function (data) {
            if ($(data).find("success").text()) {
				$('.input').val('').removeAttr('style');
				$('#loading').css('display','none');
				var text = $(data).find("success").text();
				$('.message').html(text).fadeIn(200, function(){ $(this).css('display','block')}).fadeOut(6000, function(){ $(this).css('display','none')});
            } else {
				$('.input').val('').removeAttr('style');
				$('#loading').css('display','none');
				$('.message').html($(data).find("result").text())
						.fadeIn(200, function(){ $(this).css('display','block')}).fadeOut(6000, function(){ $(this).css('display','none')});
            }
        },
        error: function () {
		   $('.input').val('').removeAttr('style');
		   $('#loading').css('display','none');
           $('.error_message').fadeIn(200, function(){ $(this).css('display','block')}).fadeOut(6000, function(){ $(this).css('display','none')});
        }
   });
}

function change_forgot_password(password, confirm) {
    $.ajax({
		dataType: "xml",
        url: "/app/switch/site_actions.php",
        type: "POST",
        data: {
            action: "change_forgot_password",
			password: password,
			confirm: confirm
        },
        success: function (data) {
            if ($(data).find("success").text()) {
				$('.input').val('').removeAttr('style');
				$('#loading').css('display','none');
				var text = $(data).find("success").text();
				$('.message').html(text).fadeIn(200, function(){ $(this).css('display','block')}).fadeOut(6000, function(){ $(this).css('display','none')});
				var delay = 6000;
				setTimeout("document.location.href='/'", delay);
            } else {
				$('.input').val('').removeAttr('style');
				$('#loading').css('display','none');
				var text = $(data).find("result").text();
				$('.message').html(text).fadeIn(200, function(){ $(this).css('display','block')}).fadeOut(6000, function(){ $(this).css('display','none')});
            }
        },
        error: function () {
		   $('.input').val('').removeAttr('style');
		   $('#loading').css('display','none');
           $('.error_message').fadeIn(200, function(){ $(this).css('display','block')}).fadeOut(6000, function(){ $(this).css('display','none')});
        }
   });
}

function Exit(){
	  $.ajax({
		dataType: "xml",
        url: "/app/switch/site_actions.php",
        type: "POST",
        data: {
            action: "exit"
		},
        success: function (data) {
            if ($(data).find("success").text()) {
				$('.input').val('').removeAttr('style');
				$('#loading').css('display','none');
				var text = $(data).find("success").text();
				$('.message').html(text).fadeIn(200, function(){ $(this).css('display','block')}).fadeOut(6000, function(){ $(this).css('display','none')});
				var delay = 500;
				setTimeout("document.location.href='/'", delay);
            } else {
				$('.input').val('').removeAttr('style');
				$('#loading').css('display','none');
				$('.message').html($(data).find("result").text())
						.fadeIn(200, function(){ $(this).css('display','block')}).fadeOut(6000, function(){ $(this).css('display','none')});
            }
        },
        error: function () {
		   $('.input').val('').removeAttr('style');
		   $('#loading').css('display','none');
           $('.error_message').fadeIn(200, function(){ $(this).css('display','block')}).fadeOut(6000, function(){ $(this).css('display','none')});
        }

        });
}

function goToProfile() {
	window.location="/profile";
}

function change_Password( old, password, confirm ) {
		$.ajax({
			dataType: "xml",
			url: "/app/switch/site_actions.php",
			type: "POST",
			data: {
				action : "change_Password",
				old : old,
				password : password,
				confirm : confirm
			},
			success: function (data) {
            if ($(data).find("success").text()) {
				$('.input').val('').removeAttr('style');
				$('#loading').css('display','none');
				var text = $(data).find("success").text();
				$('.message').html(text).fadeIn(200, function(){ $(this).css('display','block')}).fadeOut(6000, function(){ $(this).css('display','none')});
            } else {
				$('.input').val('').removeAttr('style');
				$('#loading').css('display','none');
				$('.message').html($(data).find("result").text())
						.fadeIn(200, function(){ $(this).css('display','block')}).fadeOut(6000, function(){ $(this).css('display','none')});
            }
        },
        error: function () {
		   $('.input').val('').removeAttr('style');
		   $('#loading').css('display','none');
           $('.error_message').fadeIn(200, function(){ $(this).css('display','block')}).fadeOut(6000, function(){ $(this).css('display','none')});
        }

	   });
	}

function Translator(lang){
	$.ajax({
			dataType: "xml",
			url: "/app/switch/site_actions.php",
			type: "POST",
			data: {
				action : "lang",
				lang : lang
			},
		success: function (data) {
			if ($(data).find("success")){
					location.reload();
			}
        },
        error: function () {
		  	alert('Ошибка на сервере');
        }

	   });
	}

/*--------------------------------Бибиотека функций конец блока-----------------------------------*/