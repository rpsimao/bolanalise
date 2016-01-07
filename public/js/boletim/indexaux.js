$(function(){
	
	if( $("#tipo_txt").val().length > 0 ) {  checkMyBox('tipo'); }
	if( $("#gramagem_txt").val().length > 0 ) {  checkMyBox('gramagem'); }
	if( $("#espessura_txt").val().length > 0 ) {  checkMyBox('espessura'); }
	if( $("#cores_txt").val().length > 0 ) {  checkMyBox('cores'); }
	if( $("#dimensoes_cartonagem_txt").val().length > 0 ) {  checkMyBox('dimensoes_cartonagem'); }
	
	/**if ($("#cliente").val() == "Lusomedicamenta, SA")
	{
		$('#boletim_completo').find(':input').each(function() {
	        switch(this.type) {
	            case 'password':
	            case 'select-multiple':
	            case 'select-one':
	            case 'text':
	            case 'textarea':
	                $(this).val('');
	                break;
	            case 'checkbox':
	            case 'radio':
	                this.checked = false;
	        }
	    });
			
	}*/

});

