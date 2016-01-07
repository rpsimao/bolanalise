$(function(){


$("#et").hide();
$("#ie").hide();
$("#img").hide();



$('#et-th').toggle( 
	    function() { 
	    	$("#et").fadeIn();
	    }, 
	    function() { 
	    	$("#et").fadeOut();
	    } 
	);


$('#ie-th').toggle( 
	    function() { 
	    	$("#ie").fadeIn();
	    }, 
	    function() { 
	    	$("#ie").fadeOut();
	    } 
	);


$('#img-th').toggle( 
	    function() { 
	    	$("#img").fadeIn();
	    }, 
	    function() { 
	    	$("#img").fadeOut();
	    } 
	);



$('#et-th').tooltip({title:"Clique para ver.", placement:"top"});
$('#ie-th').tooltip({title:"Clique para ver.", placement:"top"});
$('#img-th').tooltip({title:"Clique para ver.", placement:"top"});







});



function checkMyBox(param)
{
	
	$('#' + param).attr('checked', true);
}



function validatebolform()
{
	var corts = {foo: $('#obs').val().substr(20, 2)};
	
	var $aprovado = $('#aprovado');
	
	if (!$aprovado.is(':checked'))
		{
			$('#msg').show();
			$('#msg_txt').html('<h4><i class="icon-minus-sign icon-large"></i> Atenção!</h4>Não aprovou a embalagem.');
			return false;
			
		} else if( corts.foo == "XX"){
			
			$('#msg').show();
			$('#msg_txt').html('<h4><i class="icon-minus-sign icon-large"></i> Atenção!</h4>O número de cortantes nas Observações não é válido.');
			delete corts.foo;
			return false;
		
		} else {
			
			return true;
		}



}



