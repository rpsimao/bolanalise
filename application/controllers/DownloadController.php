<?php

class DownloadController extends Zend_Controller_Action
{

    public function init()
    {
        /* Initialize action controller here */
    }

    public function indexAction()
    {
        // action body
    }

    public function pdfAction()
    {
       $this->_helper->layout()->disableLayout(); 
        $bolid = $this->_getParam('id');
        
        $pdf = new RPS_User_Service_CreatePDF();
        $pdf->savePDF($bolid);
        
        $this->view->bolid = $bolid;
    }


}



