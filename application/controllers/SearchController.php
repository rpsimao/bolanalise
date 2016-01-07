<?php

class SearchController extends Zend_Controller_Action
{

    protected $db;


	public function init()
    {
        if ($this->_helper->FlashMessenger->hasMessages()) 
        {
            $this->view->messages = $this->_helper->FlashMessenger->getMessages();
        }  
        
        $this->view->ck = new Application_Model_Mail();
        $this->db = new Application_Model_Boletins();
        $this->view->h = $this->view->ck->countBoletins();
        $this->view->b = count($this->db->getAllByClient('Bluepharma-Ind. Farmac. SA'));
    }

    public function indexAction()
    {
        if ($this->getRequest()->isPost())
        {
            $jnumber = $this->_getParam('jnumber');
            $data = $this->db->getAllBoletinsByJobNumber($jnumber);
            
            $this->view->boletins = $data;
            $this->view->jobnumber = $jnumber;
            $this->view->type = "byjobnumber";
            
            
        } else {
            
            $jnumber = $this->_getParam('num');
            
            $data = $this->db->getAllBoletinsByJobNumber($jnumber);
            
            $this->view->boletins = $data;
            $this->view->jobnumber = $jnumber;
            $this->view->type = "byjobnumber";
            
        }
        
    }

    public function semanaAction()
    {
       $data = $this->db->getSemana();
       $this->view->total = count($data);
       
       
       if (count($data) > 0) {
            $page = $this->_getParam('page', 1);
            $paginator = Zend_Paginator::factory($data);
            $paginator->setItemCountPerPage(10);
            $paginator->setCurrentPageNumber($page);
            $this->view->boletins = $paginator;
            $this->view->h = $this->view->ck->countBoletins();
            $this->view->b = count($this->db->getAllByClient('Bluepharma-Ind. Farmac. SA'));
            $this->view->searchdate = "/search/semana/index";
            $this->view->type = "byweek";
       } else {
           $this->_helper->flashMessenger->addMessage('info');
           $this->_helper->flashMessenger->addMessage('Não existe nenhum boletim para esta data.');
           $this->redirect('/');
       }
       
       
        
    }

    public function bpAction()
    {
        $page = $this->_getParam('page', 1);
        $paginator = Zend_Paginator::factory($this->db->filterBluepharmaMail());
        $paginator->setItemCountPerPage(10);
        $paginator->setCurrentPageNumber($page);
        $this->view->boletins = $paginator;
        $this->view->b = count($this->db->getAllByClient('Bluepharma-Ind. Farmac. SA'));
        
    }


	public function emailsAction()
	{

		$page = $this->_getParam('page', 1);
		$lab = $this->_getParam("lab");





	}


    public function mesAction()
    {
       $data = $this->db->getMes();
       $this->view->total = count($data);
       
       if (count($data) > 0) {
           $page = $this->_getParam('page', 1);
            $paginator = Zend_Paginator::factory($data);
            $paginator->setItemCountPerPage(10);
            $paginator->setCurrentPageNumber($page);
            $this->view->boletins = $paginator;
            $this->view->h = $this->view->ck->countBoletins();
            $this->view->b = count($this->db->getAllByClient('Bluepharma-Ind. Farmac. SA'));
            $this->view->searchdate = "/search/mes/index";
            $this->view->type = "bymonth";
       } else {
           $this->_helper->flashMessenger->addMessage('info');
           $this->_helper->flashMessenger->addMessage('Não existe nenhum boletim para esta data.');
           $this->redirect('/');
       }
       
       
        
    }

    public function anoAction()
    {
       
        
       $data = $this->db->getYear();
       $this->view->total = count($data);
       
       if (count($data) > 0) {
           $page = $this->_getParam('page', 1);
            $paginator = Zend_Paginator::factory($data);
            $paginator->setItemCountPerPage(10);
            $paginator->setCurrentPageNumber($page);
            $this->view->boletins = $paginator;
            $this->view->h = $this->view->ck->countBoletins();
            $this->view->b = count($this->db->getAllByClient('Bluepharma-Ind. Farmac. SA'));
            $this->view->searchdate = "/search/mes/index";
            $this->view->type = "bymonth";
       } else {
           $this->_helper->flashMessenger->addMessage('info');
           $this->_helper->flashMessenger->addMessage('Não existe nenhum boletim para esta data.');
           $this->redirect('/');
       }
       
    }


}