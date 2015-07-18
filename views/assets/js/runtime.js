/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */



$('#inputLogin').click(function(){
	var mobile = $('#inputMobile').val();
	var password = $('#inputPassword').val();
	$.ajax({
		type: "POST",
		url: "/auth/login",
		data: "mobile="+mobile+"&password="+password,
		success: function (data) {
			// Play with returned data in JSON format
			if(data.substring(0,1) != "0")
			{
				alert(data.substring(1));
			}else{
				var author = data.split(':');
				//window.location.reload();
				$.cookie("token",author[2], { expires: 1});
				$('#inputCancel').trigger('click');
				$('#think').trigger('click');
				$('#author-name').html(author[1]);
				$('#author-action').css('display','block');
			}
		},
		error: function (msg) {
			alert(msg);
		}
	});
});
$('#inputRegister').click(function(){
	var mobile = $('#inputMobile').val();
	var password = $('#inputPassword').val();
	$.ajax({
		type: "POST",
		url: "/auth/register",
		data: "mobile="+mobile+"&password="+password,
		success: function (data) {
			// Play with returned data in JSON format
			if(data.substring(0,1) != "0")
			{
				alert(data.substring(1));
			}else{
				var author = data.split(':');
				//window.location.reload();
				$.cookie("token",author[2], { expires: 1});
				$('#inputCancel').trigger('click');
				$('#think').trigger('click');
				$('#author-name').html(author[1]);
				$('#author-action').css('display','block');
			}
		},
		error: function (msg) {
			alert(msg);
		}
	});
});

$('#inputLogout').click(function(){
	$.cookie("token",'');
	$('#author-name').html('鲁迅');
	$('#author-action').css('display','none');
	window.location.href = '/';
});