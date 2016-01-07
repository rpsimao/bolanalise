<?php
class SearchocController extends Zend_Controller_Action
{

    public function init()
    {
        if ($this->_helper->FlashMessenger->hasMessages()) {
            $this->view->messages = $this->_helper->FlashMessenger->getMessages();
        }
        $this->view->ck = new Application_Model_Mail();
        
    }

    public function indexAction()
    {
    if ($this->getRequest()->isPost())
        {
            $oc= $this->_getParam('navbarocform');
            $db = new Application_Model_Boletins();
            $data = $db->getBolByOC($oc);
            
            $this->view->boletins = $data;
            $this->view->oc = $oc;
            
            
        }
            
            
        
    }

    public function bpAction()
    {
            
        $this->_helper->viewRenderer->setRender('index');
            $oc = $this->_getParam('oc');
            $db = new Application_Model_Boletins();
            $data = $db->getBolByOC($oc);
            
            $this->view->boletins = $data;
            $this->view->oc = $oc;
    }

    public function zimbraAction()
    {
        $this->_helper->layout()->disableLayout(); 
        $this->_helper->viewRenderer->setNoRender(true);
        
        $oc   = $this->_getParam('oc');
        $db   = new Application_Model_Boletins();
        $data = $db->getBolByOC($oc)->toArray();
        
        $howmany = count($data);
        
        foreach ($data as $value) {
            $params[] = $value['id']; 
        }
        
        $params1 = array('total' => $howmany);
        array_merge($params1, $params);
        
        $json = Zend_Json_Encoder::encode($params1);
        
        $this->getResponse()->appendBody($json);
        
    }


}