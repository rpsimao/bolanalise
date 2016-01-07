function triggerdate()
{
	var inputvalue = $("#navbardateform").val();
	var url        = "/searchdate/";

	window.location = url + inputvalue;
}


function showOpcoes(){
	$("#showOpcoesNavBar").toggle(
		$('#opcoesProcuraNavBar').text($("#showOpcoesNavBar").is(':visible') ? "Mostrar Opções" : "Esconder Opções"),
		$('#first-nav').toggle('slow')
		
	);
}

function mypopover(id)
{

	var splitId = id.split("-");
	
	
	$("#thumb-"+id).qtip({

	    content: {

	    	text: '<div class="txt-center top-5"><i class="icon-spinner icon-spin icon-3x"></i><p class="top-10 txt-12">A obter dados...<br /><small>Por favor aguarde.</small></p></div>',
			ajax: {
				url: "/ajax/images/?jnumber=" + splitId[0]
			},
			title: {
				text: "Embalagem Thumbnail",
				button: true
			}
		},
		position: {
			at: 'bottom center',
			my: 'top center',
			viewport: $(window),
			effect: false
		},
		show: {
			event: 'click',
			solo: true
		},
		hide: 'mouseout',
		style: {
			classes: 'qtip-wiki qtip-light qtip-shadow click'
		}
	});

}

function f3Code(jnumber)
{
	var f3code = $.ajax({
		type: 'GET',
		url: '/ajax/getf3code',
		data: {'jnumber': jnumber},
		dataType: 'html',
		async: false,
		}).responseText;

	return f3code;
}


function packInfo(jnumber){}


function imagename(id)
{
	var img = $.ajax({
			type: 'GET',
			url: '/ajax/images',
			data: {'jnumber' : id},
			dataType: 'html',
			async: false,
			}).responseText;
	return img;
}




function validatePasswd(id)
{
    var fieldID = $("#password-auth-"+id).val();

    if (fieldID == "")
    {
        $("#error-mgs-passwd-modal-"+id).html('<div class="alert alert-error"><i class="icon-minus-sign"></i> Tem de inserir a sua password!</div>');
        $("#password-auth-"+id).focus();
        return false; 
    }
    
    var validate = $.ajax({
		type: 'GET',
		url: '/ajax/checkpasswdinit',
		data: {'p': fieldID },
		dataType: 'html',
		async: false,
        beforeSend: function(){$("#authModal-"+id+"-passwd-validate").html('<i class="icon-spinner icon-spin"></i>...a validar password');},
        complete: function(){$("#authModal-"+id+"-passwd-validate").fadeOut();}
		}).responseText;

    if (validate == 0)
    {
        $("#error-mgs-passwd-modal-"+id).html('<div class="alert alert-error"><i class="icon-minus-sign"></i> A password não é válida para este recurso.</div>');
        $("#password-auth-"+id).focus().select();
        return false; 
    }
    
}

function validatePasswdDel(id)
{
    var fieldID = $("#password-del-"+id).val();

    if (fieldID == "")
    {
        $("#error-mgs-passwd-modal-del-"+id).html('<div class="alert alert-error"><i class="icon-minus-sign"></i> Tem de inserir a sua password!</div>');
        $("#password-del-"+id).focus();
        return false; 
    }
    
    var validate = $.ajax({
		type: 'GET',
		url: '/ajax/checkpasswdinit',
		data: {'p': fieldID },
		dataType: 'html',
        beforeSend: function(){$("#authModal-"+id+"-remove-passwd-validate").html('<i class="icon-spinner icon-spin"></i>...a validar password');},
        complete: function(){$("#authModal-"+id+"-remove-passwd-validate").fadeOut();},
		async: false
		}).responseText;

    if (validate == 0)
    {
        $("#error-mgs-passwd-modal-del-"+id).html('<div class="alert alert-error"><i class="icon-minus-sign"></i> A password não é válida para este recurso.</div>');
        $("#password-del-"+id).focus().select();
        return false; 
    }
}
$(function(){

	$("#navbardateform").datepicker({ dateFormat: "yy-mm-dd" ,
		dayNamesMin: ["Dom","Seg", "Ter", "Qua", "Qui", "Sex", "Sab"],
		monthNames:["Janeiro", "Fevereiro", "Março", "Abril", "Maio", "Junho", "Julho", "Agosto", "Setembro", "Outubro", "Novembro", "Dezembro"],
		monthNamesShort: ['Jan', 'Fev', 'Mar', 'Abr', 'Mai', 'Jun', 'Jul', 'Ago', 'Set', 'Out', 'Nov', 'Dez']

	});
	$('#navbardateform').datepicker($.datepicker.regional['pt']);


});


function enviarEmailBolAnalise(bolID)
{

}