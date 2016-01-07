<?php

class SearchdateController extends Zend_Controller_Action
{

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
            $date = $this->getParam('navbardateform');
            $data = $this->db->searchByDate($date)->toArray();
            
            
            
            $d = new Zend_Date($date, "YYYY-MMMM-dd", 'pt_PT');
            $this->view->searchdate = $d;
            $this->view->type = "bydate";
            
            if (count($data) > 0) {
                $this->view->boletins = $data;
            } else {
                $this->_helper->flashMessenger->addMessage('info');
                $this->_helper->flashMessenger->addMessage('Não existe nenhum boletim para esta data.');
                $this->redirect('/');
            }
            
            
        } else {
            
            $date = $this->getParam('date');
            
            
            if ($date == "semana") {
                
                $this->redirect("/search/semana/index");
            
            } else {
                $data = $this->db->searchByDate($date);
                $d = new Zend_Date($date, "YYYY-MMMM-dd", 'pt_PT');
                
                
                if (count($data) > 0) {
                    $this->view->searchdate = $d;
                    $this->view->type = "bydate";
                } else {
                    $this->_helper->flashMessenger->addMessage('info');
                    $this->_helper->flashMessenger->addMessage('Não existe nenhum boletim para esta data.');
                    $this->redirect('/');
                }
            }
            
            
            
           if (count($data) > 0) {
               $this->view->boletins = $data;
           } else {
               $this->_helper->flashMessenger->addMessage('info');
               $this->_helper->flashMessenger->addMessage('Não existe nenhum boletim para esta data.');
               $this->redirect('/');
           }
            
         }
        
        
    }


}

