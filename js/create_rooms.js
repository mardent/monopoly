(function( $ ){
	$(function() {
		//alert("Ошибка при подключении");
		$('#createroom').click(function(e){
			e.preventDefault();
				//var id = $(this).attr('id');
				//	switch(id){
				//		case 'createroom':
							createRoomData($('#name').val(), $('#password').val(), $('#players').val(), $('#money').val(), $('#time').val());
					//}
		});
			
	});
	
})( jQuery );

	function createRoomData(name, password, players, money, time){
			$.ajax({
			dataType: "xml",
			url: "php/Lib_for_game.php",
			type: "POST",
			data: {
				action : "createRoom",
				name : name,
				password : password,
				players : players,
				money : money,
				time : time
			},
			success: function (data) {
				if ("ok" === $(data).find("result").text().toLowerCase()) {
					//$('.input').val('').removeAttr('style');
					//$('#loading').css('display','none');
					//$('.message').html('Новая комната создана!')
					//		.fadeIn(200, function(){ $(this).css('display','block')}).fadeOut(6000, function(){ $(this).css('display','none')});
					alert("Новая комната была создана");
				} else {
					//$('#name').val('').removeAttr('style');
					//$('#loading').css('display','none');
					//var text = $(data).find("result").text();
					//$('.message').html(text)
					//		.fadeIn(200, function(){ $(this).css('display','block')}).fadeOut(6000, function(){ $(this).css('display','none')});
					alert($(data).find("result").text());
				}
			},
			error: function () {
				//$('.input').val('').removeAttr('style');
				//$('#loading').css('display','none');
				//$('.message').html('Ошибка при передаче данных. Попробуйте еще раз')
				//			.fadeIn(200, function(){ $(this).css('display','block')}).fadeOut(6000, function(){ $(this).css('display','none')});
			alert("Ошибка при подключении к базе данных");
			}
		});
	}

