(function( $ ){
$(function() {	
	$("#uploadForm").on('submit',(function(e) {
		e.preventDefault();
		$.ajax({
        	url: "/app/inc/upload.php",
			type: "POST",
			dataType: "xml",
			data:  new FormData(this),
			contentType: false,
    	    cache: false,
			processData:false,
        success: function (data) {
			var res = $(data).find("result").text();
			if (res == "error") {
				alert("Your file size is more 1Mb");
			} else {
				$("#avatar").attr('src', "/images/avatars/" + res);
			}
        },
        error: function () {
			alert("Server error");//TODO
        }	        
	   });
	}));
});
})( jQuery );


function goToProfile() {
	window.location="/profile";
}

function changePassword(oldPass, newPass1, newPass2) {
	
	if (passValidation(oldPass) || passValidation(newPass1) || passValidation(newPass2)) {
		alert("Incorect Password");
	} else {
		$.ajax({
			dataType: "xml",
			url: "/app/inc/actions.php",
			type: "POST",
			data: {
				action : "password_change",
				oldPass : oldPass,
				newPass1 : newPass1,
				newPass2 : newPass2
			},
			success: function (data) {
				if ("ok" === $(data).find("result").text().toLowerCase()) {
					alert($(data).find("result").text().toLowerCase());
				} else {
					alert($(data).find("result").text().toLowerCase());
				}
			},
			error: function () {

			}
	   });
	}
}

function deleteAvatar() {
	$.ajax({
		dataType: "xml",
		url: "/app/inc/actions.php",
		type: "POST",
		data: {
			action : "deleteAvatar"
		},
		success: function (data) {
			$("#avatar").attr('src', "/images/avatars/" + $(data).find("result").text());
		},
		error: function () {

		}
    });
}

function passValidation(pass) {
	return (pass == '' || pass.length < 4 || pass.length > 25);
}