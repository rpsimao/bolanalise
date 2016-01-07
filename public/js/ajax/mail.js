function sendmail(bolid, cliente)
{
	$.ajax({
		type: 'GET',
		url: '/mail',
		data: {'id': bolid, 'cliente' : cliente},
		datatype: 'html',
		beforeSend: loading(bolid),
		complete: function(){$('#loading-animation'+bolid).fadeOut();},
			
		success: function(response) {
			$('#flash-email').fadeIn();
			$('#flash-email').html('<div class="alert alert-success" id="default_flash_message"><button type="button" class="close" data-dismiss="alert">×</button><p><i class="icon-ok-sign icon-black"></i><b> O email do Boletim de Análise Nº'+bolid+'  foi enviado com sucesso.</b></p></div>');
			$("#mailicon-" + bolid).fadeOut();

            $("#"+bolid).html('<span class="label label-success"><i class="icon-ok"></i> Enviado</span>');
			
		}
		
	});
}

function loading(bolid){
	
	$("#"+bolid).html('<small>A enviar email...</small><div class="progress progress-striped active"> <div class="bar" style="width: 100%;"></div></div>');
	
}

