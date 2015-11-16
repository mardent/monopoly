/*----------------------Проверка формы на лету начало блока----------------------*/
//$(document).ready(function(){
(function( $ ){
$(function() {	
	//------Деактивируем кнопку пока все поля не будут заполнены----//
	$('.form').each(function(){
	var form = $(this);
    var but = form.find('#reg, #log, #recover, #change_forgot_pass, #changePass');

    function checkField(){
      form.find('.input').each(function(){
        if($(this).val() != ''){
		$(this).removeClass('input_empty');
        } else {
		$(this).addClass('input_empty');
        }
      });
    }
	
    setInterval(function(){
	  checkField();
      var empty = form.find('.input_empty').length;
      if(empty > 0)
		{
			if(but.attr('disabled')){
					return false;
			} else {
					but.attr('disabled','disabled');
				   }
       } else {
			but.removeAttr('disabled')
      }
    },100);
});
//-------------------------------------||--------------------------------------------------//

//-------------------------------------Проверяем поля ввода ------------------------------//
 $('#login, #email, #password, #confirm, #name, #avatar, #old, #captcha').blur( function(){
         var id = $(this).attr('id');
         var val = $(this).val();  
       switch(id)
       {
			case 'login':
				 var rv_name = /^[a-zA-Zа-яА-Я_-]+$/;
                if(val.length > 2 && val != '' && rv_name.test(val))
                {
				   $(this).removeClass('err').addClass('not_error');
                   $(this).next('.error-login').fadeOut(800, function(){$(this).css('display','none')});
				   $(this).css('border-color','blue');
                }

                else
                {
                   $(this).removeClass('not_error').addClass('err');
				   $(this).css('border-color','red');
                   $(this).next('.error-login').html('Поле "Логин" обязательно для заполнения, длина имени должна составлять не менее 2 символов, поле может содержать только русские или латинские буквы и ( _ , - , . )')
											.fadeIn(800, function(){ $(this).css('display','block')}).fadeOut(6000, function(){$(this).css('display','none')});
                }
            break;
		   
             case 'name':
				 var rv_name = /^[a-zA-Zа-яА-Я]+$/;
                if(val.length > 2 && val != '' && rv_name.test(val))
                {
                   $(this).removeClass('err');
                   $(this).next('.error-name').fadeOut(800, function(){$(this).css('display','none')});
				   $(this).css('border-color','blue');
                }

                else
                {
                   $(this).addClass('err');
				   $(this).css('border-color','red');
                   $(this).next('.error-name').html('Поле "Имя" обязательно для заполнения. Длина не менее 2 символов и может содержать только русские или латинские буквы').fadeIn(800, function(){ $(this).css('display','block')}).fadeOut(6000, function(){$(this).css('display','none')});
                }
            break;


           case 'email':
               var rv_email = /^([a-zA-Z0-9_.-])+@([a-zA-Z0-9_.-])+\.([a-zA-Z])+([a-zA-Z])+/;
               if(val != '' && rv_email.test(val))
               {
                  $(this).removeClass('err');
                  $(this).next('.error-email').fadeOut(800, function(){$(this).css('display','none')});
				  $(this).css('border-color','blue');
               }
               else
               {
                  $(this).addClass('err');
				  $(this).css('border-color','red');
                  $(this).next('.error-email').html('Содержимое поля "Email" не является email адресом')
									.fadeIn(800, function(){ $(this).css('display','block')}).fadeOut(3000, function(){$(this).css('display','none')});
               }
           break;
		   
		   case 'password':
              if(val != '' && val.length >= 4 && val.length <= 25)
              {
                 $(this).removeClass('err');
                 $(this).next('.error-password').fadeOut(400, function(){$(this).css('display','none')});
				 $(this).css('border-color','blue');
              }
              else
              {
                 $(this).addClass('err');
				 $(this).css('border-color','red');
                 $(this).next('.error-password').html('Введите пароль. Не меньше 4 знаков.')
										   .fadeIn(400, function(){ $(this).css('display','block')}).fadeOut(3000, function(){$(this).css('display','none')});
              }
          break;
		  
		  case 'old':
              if(val != '' && val.length >= 4 && val.length <= 25)
              {
                 $(this).removeClass('err');
                 $(this).next('.error-password').fadeOut(400, function(){$(this).css('display','none')});
				 $(this).css('border-color','blue');
              }
              else
              {
                 $(this).addClass('err');
				 $(this).css('border-color','red');
                 $(this).next('.error-password').html('Введите пароль. Не меньше 4 знаков.')
										   .fadeIn(400, function(){ $(this).css('display','block')}).fadeOut(3000, function(){$(this).css('display','none')});
              }
          break;
		  
		  case 'captcha':
				var rv_name = /[0-9a-z]+/i;
                if(val.length > 4 && val != '' && rv_name.test(val))
                {
				   $(this).removeClass('err').addClass('not_error');
                   $(this).next('.error-captcha').fadeOut(800, function(){$(this).css('display','none')});
				   $(this).css('border-color','blue');
                }

                else
                {
                   $(this).removeClass('not_error').addClass('err');
				   $(this).css('border-color','red');
                   $(this).next('.error-captcha').html('Введите изображение с картинки')
											.fadeIn(800, function(){ $(this).css('display','block')}).fadeOut(6000, function(){$(this).css('display','none')});
                }
            break;
		  
       } // конец switch;

     }); // конец blur;
	 
	  $('#confirm').bind('keyup focus', function() {
			  password = $('#password').val();
			  confirmation   = $(this).val();
			  if (password == confirmation && confirmation != 0) {
				 $(this).removeClass('err');
                 $(this).next('.error-confirm').fadeOut(200, function(){$(this).css('display','none')});
				 $(this).css('border-color','blue');
			  } else {
				 $(this).addClass('err');
				 $(this).css('border-color','red');
                
			  }
 
	});
		$('#reg, #log, #recover, #change_forgot_pass, #changePass').click(function(e){
			e.preventDefault();
				if($('.form').find('.err').length > 0)
				{
					$('.message').html('Внимательно заполните поля формы')
										   .fadeIn(200, function(){ $(this).css('display','block')}).fadeOut(6000, function(){ $(this).css('display','none')});
					$('.form').find('.err').each(function(){
						$(this).fadeIn(200, function(){$(this).css({'border':'2px solid red'})});
					});
				}else{
					 var id = $(this).attr('id');
						switch(id){
							case 'reg':
								 sendRegData($('#login').val(), $('#password').val(), $('#name').val(), $('#email').val(), $('#captcha').val());
								$('#loading').css('display','block');
								var opts = {
								lines: 13, // Число линий для рисования
								length: 0, // Длина каждой линии
								width: 10, // Толщина линии
								radius: 30, // Радиус внутреннего круга
								corners: 1, // Скругление углов (0..1)
								rotate: 0, // Смещение вращения
								direction: 1, // 1: по часовой стрелке, -1: против часовой стрелки
								color: '#000', // #rgb или #rrggbb или массив цветов
								speed: 2.2, // Кругов в секунду
								trail: 17, // Послесвечение
								shadow: false, // Тень(true - да; false - нет)
								hwaccel: false, // Аппаратное ускорение
								className: 'spinner', // CSS класс
								zIndex: 2e9, // z-index (по-умолчанию 2000000000)
								top: '50%', // Положение сверху относительно родителя
								left: '50%' // Положение слева относительно родителя
							   };
								var target = document.getElementById('loading');
								var spinner = new Spinner(opts).spin(target);

							break;
							
							case 'log':
								login($('#login').val(), $('#password').val());
								$('#loading').css('display','block');
								var opts = {
								lines: 13, // Число линий для рисования
								length: 0, // Длина каждой линии
								width: 10, // Толщина линии
								radius: 30, // Радиус внутреннего круга
								corners: 1, // Скругление углов (0..1)
								rotate: 0, // Смещение вращения
								direction: 1, // 1: по часовой стрелке, -1: против часовой стрелки
								color: '#000', // #rgb или #rrggbb или массив цветов
								speed: 2.2, // Кругов в секунду
								trail: 17, // Послесвечение
								shadow: false, // Тень(true - да; false - нет)
								hwaccel: false, // Аппаратное ускорение
								className: 'spinner', // CSS класс
								zIndex: 2e9, // z-index (по-умолчанию 2000000000)
								top: '50%', // Положение сверху относительно родителя
								left: '50%' // Положение слева относительно родителя
							   };
								var target = document.getElementById('loading');
								var spinner = new Spinner(opts).spin(target);
							break;
							
							case 'recover':
								$('#loading').css('display','block');
								forgotPass($('#email').val());
								var opts = {
								lines: 13, // Число линий для рисования
								length: 0, // Длина каждой линии
								width: 10, // Толщина линии
								radius: 30, // Радиус внутреннего круга
								corners: 1, // Скругление углов (0..1)
								rotate: 0, // Смещение вращения
								direction: 1, // 1: по часовой стрелке, -1: против часовой стрелки
								color: '#000', // #rgb или #rrggbb или массив цветов
								speed: 2.2, // Кругов в секунду
								trail: 17, // Послесвечение
								shadow: false, // Тень(true - да; false - нет)
								hwaccel: false, // Аппаратное ускорение
								className: 'spinner', // CSS класс
								zIndex: 2e9, // z-index (по-умолчанию 2000000000)
								top: '50%', // Положение сверху относительно родителя
								left: '50%' // Положение слева относительно родителя
							   };
								var target = document.getElementById('loading');
								var spinner = new Spinner(opts).spin(target);
							break;
							
							case 'change_forgot_pass':
								$('#loading').css('display','block');
								change_forgot_password($('#password').val(), $('#confirm').val());
								var opts = {
								lines: 13, // Число линий для рисования
								length: 0, // Длина каждой линии
								width: 10, // Толщина линии
								radius: 30, // Радиус внутреннего круга
								corners: 1, // Скругление углов (0..1)
								rotate: 0, // Смещение вращения
								direction: 1, // 1: по часовой стрелке, -1: против часовой стрелки
								color: '#000', // #rgb или #rrggbb или массив цветов
								speed: 2.2, // Кругов в секунду
								trail: 17, // Послесвечение
								shadow: false, // Тень(true - да; false - нет)
								hwaccel: false, // Аппаратное ускорение
								className: 'spinner', // CSS класс
								zIndex: 2e9, // z-index (по-умолчанию 2000000000)
								top: '50%', // Положение сверху относительно родителя
								left: '50%' // Положение слева относительно родителя
							    };
								var target = document.getElementById('loading');
								var spinner = new Spinner(opts).spin(target);
							break;
								
							
							case 'changePass':
								$('#loading').css('display','block');
								change_Password($('#old').val(), $('#password').val(), $('#confirm').val());
								var opts = {
								lines: 13, // Число линий для рисования
								length: 0, // Длина каждой линии
								width: 10, // Толщина линии
								radius: 30, // Радиус внутреннего круга
								corners: 1, // Скругление углов (0..1)
								rotate: 0, // Смещение вращения
								direction: 1, // 1: по часовой стрелке, -1: против часовой стрелки
								color: '#000', // #rgb или #rrggbb или массив цветов
								speed: 2.2, // Кругов в секунду
								trail: 17, // Послесвечение
								shadow: false, // Тень(true - да; false - нет)
								hwaccel: false, // Аппаратное ускорение
								className: 'spinner', // CSS класс
								zIndex: 2e9, // z-index (по-умолчанию 2000000000)
								top: '50%', // Положение сверху относительно родителя
								left: '50%' // Положение слева относительно родителя
							   };
							   var target = document.getElementById('loading');
							   var spinner = new Spinner(opts).spin(target);
							break;
					}
				}
		});
});
})( jQuery );

/*--------------------------------Проверка формы на лету конец блока-------------------------------*/


/*--------------------------------Бибиотека функций начало блока-----------------------------------*/
function clickBack() {
	document.location.href ='/';
}

function sendRegData(login, password, name, email, captcha){
	    $.ajax({
		dataType: "xml",
        url: "/app/inc/actions.php",
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
            if ("ok" === $(data).find("result").text().toLowerCase()) {
				//location.replace("/");
				$('.input').val('').removeAttr('style');
				$('#loading').css('display','none');
				$('.message').html('Поздравляем. Вы успешно зарегистрированы!')
						.fadeIn(200, function(){ $(this).css('display','block')}).fadeOut(6000, function(){ $(this).css('display','none')});
            } else {
				//$('.input').val('').removeAttr('style');
				$('#password').val('').removeAttr('style');
				$('#confirm').val('').removeAttr('style');
				document.getElementById('captcha_image').src='app/inc/captcha.php?'+Math.random();
				$('#loading').css('display','none');
                var text = $(data).find("result").text();
				$('.message').html(text)
						.fadeIn(200, function(){ $(this).css('display','block')}).fadeOut(6000, function(){ $(this).css('display','none')});
            }
        },
        error: function () {
			$('.input').val('').removeAttr('style');
			$('#loading').css('display','none');
            $('.message').html('Ошибка при передаче данных. Попробуйте еще раз')
						.fadeIn(200, function(){ $(this).css('display','block')}).fadeOut(6000, function(){ $(this).css('display','none')});
        }
    });
}

function login(login, password) {
    $.ajax({
		dataType: "xml",
        url: "/app/inc/actions.php",
        type: "POST",
        data: {
            action: "authorization",
            login: login,
            password: password
        },
        success: function (data) {
            if ("ok" === $(data).find("result").text().toLowerCase()) {
                location.replace("/cabinet");
				$('.input').val('').removeAttr('style');
				$('#loading').css('display','none');
            } else {
				$('.input').val('').removeAttr('style');
				$('#loading').css('display','none');
                var text = $(data).find("result").text();
				$('.message').html(text)
						.fadeIn(200, function(){ $(this).css('display','block')}).fadeOut(6000, function(){ $(this).css('display','none')});
            }
        },
        error: function () {
		   $('.input').val('').removeAttr('style');
		   $('#loading').css('display','none');
           $('.message').html('Ошибка при передаче данных. Попробуйте еще раз')
						.fadeIn(200, function(){ $(this).css('display','block')}).fadeOut(6000, function(){ $(this).css('display','none')});
        }
   });
}


function forgotPass(email) {
    $.ajax({
		dataType: "xml",
        url: "/app/inc/actions.php",
        type: "POST",
        data: {
            action: "forgot",
			email: email
        },
        success: function (data) {
            if ("ok" === $(data).find("result").text().toLowerCase()) {
				$('.input').val('').removeAttr('style');
				$('#loading').css('display','none');
				$('.message').html('Вам на почту отправлены дальнейшие инструкции')
						.fadeIn(200, function(){ $(this).css('display','block')}).fadeOut(6000, function(){ $(this).css('display','none')});
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
           $('.message').html('Ошибка при передаче данных. Попробуйте еще раз')
						.fadeIn(200, function(){ $(this).css('display','block')}).fadeOut(6000, function(){ $(this).css('display','none')});
        }
   });
}

function change_forgot_password(password, confirm) {
    $.ajax({
		dataType: "xml",
        url: "/app/inc/actions.php",
        type: "POST",
        data: {
            action: "change_forgot_password",
			password: password,
			confirm: confirm
        },
        success: function (data) {
            if ("ok" === $(data).find("result").text().toLowerCase()) {
				$('.input').val('').removeAttr('style');
				$('#loading').css('display','none');
				$('.message').html('Пароль успешно изменен. Вы будете пренаправлены на страницу входа')
						.fadeIn(200, function(){ $(this).css('display','block')}).fadeOut(6000, function(){ $(this).css('display','none')});
				var delay = 6000;
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
           $('.message').html('Ошибка при передаче данных. Попробуйте еще раз')
						.fadeIn(200, function(){ $(this).css('display','block')}).fadeOut(6000, function(){ $(this).css('display','none')});
        }
   });
}

function Exit(){
	  $.ajax({
		dataType: "xml",
        url: "/app/inc/actions.php",
        type: "POST",
        data: {
            action: "exit"
		},
        success: function (data) {
            if ("ok" === $(data).find("result").text().toLowerCase()) {
				$('.input').val('').removeAttr('style');
				$('#loading').css('display','none');
				$('.message').html('Досвидания')
						.fadeIn(200, function(){ $(this).css('display','block')}).fadeOut(6000, function(){ $(this).css('display','none')});
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
           $('.message').html('Ошибка')
						.fadeIn(200, function(){ $(this).css('display','block')}).fadeOut(6000, function(){ $(this).css('display','none')});
        }

        });
}

function goToProfile() {
	window.location="/profile";
}

function change_Password( old, password, confirm ) {
		$.ajax({
			dataType: "xml",
			url: "/app/inc/actions.php",
			type: "POST",
			data: {
				action : "change_Password",
				old : old,
				password : password,
				confirm : confirm
			},
			success: function (data) {
            if ("ok" === $(data).find("result").text().toLowerCase()) {
				$('.input').val('').removeAttr('style');
				$('#loading').css('display','none');
				$('.message').html('Пароль успешно изменен')
						.fadeIn(200, function(){ $(this).css('display','block')}).fadeOut(6000, function(){ $(this).css('display','none')});
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
           $('.message').html('Ошибка при передаче данных. Попробуйте еще раз')
						.fadeIn(200, function(){ $(this).css('display','block')}).fadeOut(6000, function(){ $(this).css('display','none')});
        }

	   });
	}

/*--------------------------------Бибиотека функций конец блока-----------------------------------*/