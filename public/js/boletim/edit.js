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