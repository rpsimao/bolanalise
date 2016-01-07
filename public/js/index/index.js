$(function(){
$("#password").focus();

$('#password').keyup(function(){
	
	var charLength = $(this).val().length;
	if (charLength == 4 )
		{
		checkPasswd($("#password").val());				
		}
});


$('#bolanalise').keyup(function(){
	
	var charLength = $(this).val().length;
	if (charLength == 4 )
		{
		var today = $.ajax({
			type: 'GET',
			url: '/ajax/gettoday',
			dataType: 'html',
			async: false,
			}).responseText;

	
		$(this).val($(this).val() + today);
		
		}
});



});



function checkPasswd(passwd)
{
	
	$.ajax({
		type: 'GET',
		url: '/ajax/checkpasswdinit',
		data: 'p=' + passwd,
		datatype: 'html',
		beforeSend: loading(),
		complete: function(){$('#validate-init-passsowrd').remove();},
			
		success: function(response) {
			
			if (response == 1){
			
			$("#init-lock-form").removeClass('icon-lock').addClass('icon-unlock');
			$("#password").css({'backgroundColor':"#c6fbd3", 'borderColor':"#5ae078"});
			$('#validate-init-passsowrd').fadeOut();
			$("#bolanalise").focus();
			} else {
				$("#password").css({'backgroundColor':"#ffd3d1", 'borderColor':"red"});
				$("#password").focus();
				$('#validate-init-passsowrd').fadeOut();
			}
		}

	});


}

function loading()
{
	
	$('<span class="label label-info sp-bottom-8" id="validate-init-passsowrd"><i class="icon-spinner icon-spin"></i> A validar password...</span>').insertBefore("#password");


}