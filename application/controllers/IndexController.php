<?php

class IndexController extends Zend_Controller_Action
{

    public function init()
    {
        $this->mail = new Application_Model_Mail();
        $this->boletins = new Application_Model_Boletins();
    }
    
    
    public function preDispatch()
    {
        if ($this->_helper->FlashMessenger->hasMessages()) {
            $this->view->messages = $this->_helper->FlashMessenger->getMessages();
        }
    }

    public function indexAction()
    {
        $this->view->form = new Application_Form_Initbol();
       $this->view->h    = $this->mail->countBoletins();
        $this->view->b   = count($this->boletins->getAllByClient('Bluepharma-Ind. Farmac. SA'));
    }

    public function testAction()
    {
       
        
      
    }

    public function typeAction()
    {
        // action body
    }

   

}





