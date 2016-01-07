<?php
/**
 * Created by PhpStorm.
 * User: rpsimao
 * Date: 24/03/15
 * Time: 14:39
 */

class RPS_Aux_MailSent {

	public static function check($id, $cliente){
		$db = new Application_Model_Mail();
		$status = $db->getEmailStatus($id);


		$db1 = new Application_Model_Emails();
		$exists = $db1->findCliente($cliente);


		if ($status == 0 && $exists == TRUE){

			return '<span class="btn btn-mini btn-primary" onclick="sendmail('."'".preg_replace('/\s+/', '', $id)."',"."'".$cliente."'". ')"><i class="icon-share-alt"></i> Enviar</button>';

		} elseif ($status == 1) {

			//return '<span class="label label-success"><i class="icon-ok"></i> Enviado</span> &nbsp;<a style="text-decoration:none;cursor:pointer;"><i class="icon-reply-all"></i></a>';

			$html = '<div class="btn-group">
  						<button class="btn btn-success btn-mini disabled"><i class="icon-ok"></i> Enviado</button>
  							<button class="btn btn-success btn-mini dropdown-toggle" data-toggle="dropdown">
    							<span class="caret"></span>
  							</button>
  							<ul class="dropdown-menu">
							    <li><a href="#" onclick="sendmail('."'".preg_replace('/\s+/', '', $id)."',"."'".$cliente."'". ')"><i class="icon-mail-forward"></i> Reenviar Email</a></li>
							</ul>
				     </div>';

			return $html;

		} else {

			return '<span class="label"><i class="icon-ban-circle"></i> não disponível</span>';
		}


	}

}