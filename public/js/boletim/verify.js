$(function(){
	
	
	var cores     = $("#cores_txt");
	var dimensoes = $("#dimensoes_cartonagem_txt");
	var obra      = $("#obra");
	var coresUp   = cores.val().toUpperCase();
	
	$.ajax({
		type: 'GET',
		url: '/ajax/verify',
		data: 'job=' + obra.val(),
		datatype: 'html',
		beforeSend: loading(),
		complete: function(){$('#loading-animation').fadeOut(10000);},
			
		success: function(response) {
			
			var values = response.split("-");
			
			if (coresUp != values[0])
				{
					$('<span class="alert-optimus" id="alert-cores" onmouseover="loadtxt2()"><i class="icon-warning-sign"></i> O valor difere do Optimus. <small>(clique para ver)</small></span>').insertAfter(cores);
					$("#cores_txt").css("backgroundColor", "#ffe3e3");
					
				}
			
			if (dimensoes.val() != values[1])
				{
					$('<span class="alert-optimus" id="alert-dimensoes" onmouseover="loadtxt1()"><i class="icon-warning-sign"></i> O valor difere do Optimus. <small>(clique para ver)</small></span>').insertAfter(dimensoes);
					$("#dimensoes_cartonagem_txt").css("backgroundColor", "#ffe3e3");
				}
		}
		
	});
	
	
	var cliente = $("#cliente").val();

	if (cliente == "Tecnimede, SA" || cliente == "Atlantic Pharma-P. Farmac, SA" || cliente == "West Pharma, SA")
		{
			$("#gtm").html('<div class="alert alert-info"><i class="icon-exclamation-sign"></i> <b>Atenção!</b> Incluír nº de cortantes nas Observações.</div>');
			$("#obs").text("Plano de impressão: XX cortantes");
		
		}
	
});


function loadtxt1()
{
	var dimensoes = $("#dimensoes_cartonagem_txt");
	var obra = $("#obra").val();
	$("#alert-dimensoes").qtip({

	    
	    content: {
			text: '<img src="http://static.fterceiro.pt/assets/public/images/ajax-loader.gif" />',
			ajax: {
				url: "/ajax/optimustxt1?job=" + obra +"&d=" + dimensoes.val(),
			},
			title: {
				text: "Dados do Optimus",
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

function loadtxt2()
{
	var cores = $("#cores_txt").val();
	var cleanCores = cores.replace(/\+/g,"*");
	var obra = $("#obra").val();

	$("#alert-cores").qtip({

	    
	    content: {
			text: '<img src="http://static.fterceiro.pt/assets/public/images/ajax-loader.gif" />',
			ajax: {
				url: "/ajax/optimustxt2?job=" + obra +"&d=" + cleanCores,
			},
			title: {
				text: "Dados do Optimus",
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


function loading()
{	
	$('#loading-animation').fadeIn();
	$('#loading-animation').html('<span class="left-20"><i class="icon-spinner icon-spin"></i> A verificar dados com o Optimus...</span>');
	
	
	
	
}











