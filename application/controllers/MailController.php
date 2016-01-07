<?php

class MailController extends Zend_Controller_Action
{

    public function init()
    {
        /* Initialize action controller here */
    }

    public function indexAction()
    {
        
        $this->_helper->layout()->disableLayout(); 
        $this->_helper->viewRenderer->setNoRender(true);
        
        $bolid = $this->_getParam('id');
	    $cliente = $this->_getParam('cliente');
        
        $bol = new Application_Model_Boletins();
        $values = $bol->getBoletim($bolid);
        
        $pdf = new RPS_User_Service_CreatePDF();
        $pdf->savePDF($bolid);


	    $to = new Application_Model_Emails();
	    $emails = $to->getEmails($cliente);
        
        $mail = new RPS_User_Service_Mail();
	    $mail->setDestinations($emails['emails']);
        $mail->setAttachment($bolid);
        $mail->setBoletimDetails(array('nomecx'      => $values[0]['produto'], 
                                       'ordemcompra' => $values[0]['encomenda'] , 
                                       'id'          => $bolid, 
                                       'codigo'      => $values[0]['codigo']
                                 ));
        $mail->sendMail();
        
        $check = new Application_Model_Mail();
        $check->setValues(array('bolid' => $bolid, 'enviado' => 1));
        $check->setEmailStatus();
        
        $result = Zend_Json_Encoder::encode(array('resp' => "mail enviado"));
        $this->getResponse()->appendBody($result);
        
    }


}

