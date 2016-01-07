<?php

class BoletimController extends Zend_Controller_Action
{

    public function init ()
    {
        $this->_helper->layout()->setLayout('boletim');
        $this->view->setEscape('stripslashes');
    }

    public function preDispatch ()
    {
        if ($this->_helper->FlashMessenger->hasMessages()) {
            $this->view->messages = $this->_helper->FlashMessenger->getMessages();
        }
    }

    public function indexAction ()
    {
        if ($this->getRequest()->isPost()) {
            $this->form = new Application_Form_Initbol();
            if ($this->form->isValid($_POST)) {
                $this->view->init_values = $this->form->getValues();
                
                $optimus = new Application_Model_Optimus();
                
                $pass = new Application_Model_Passwords();
                $this->view->username = $pass->getRecords($this->view->init_values['password']);
                $this->view->opt_values = $optimus->getJob($this->view->init_values['obra']);
                $this->view->customername = $optimus->getCustomers($this->view->opt_values[0]['j_customer']);
                
                $this->view->bolform = new Application_Form_Boletim();
                
                $embalagem = new Application_Model_Embalagem();
                $values = $embalagem->getRecordsByJobNumber($this->view->init_values['obra']);
                
                $q = new Application_Model_TM();
                $qty = $q->getQtyMachine112($this->view->init_values['obra']);
                
                // Separar gramagem do tipo
                $sep = explode("/", $values['cartolina']);
                $this->view->tipo = RPS_User_Service_ProcessCartonType::Luso($sep[0], $this->view->init_values['obra']);
                $this->view->gramagem = $sep[1];
                $this->view->espessura = $values['espessura'];
                $this->view->cores = $values['numcores'];
                $this->view->dimensoes = $values['formato'];
                $this->view->qty = $qty;
                
                $optimus = new Application_Model_Optimus();
                $this->view->txt1 = $optimus->getJobInfo1($this->view->init_values['obra']);
                $this->view->txt2 = $optimus->getJobInfo2($this->view->init_values['obra']);
                
                $db = new Application_Model_Embalagem();
                $codF3 = $db->getRecordsByJobNumber($this->view->init_values['obra']);
                $codF3 = substr($codF3['codf3'], 0,5);
                
                $url = @getimagesize("http://imagens.fterceiro.pt/media/scope/imagens_ricardo/" . $codF3 . ".jpg");
                
                if (is_array($url)) {
                    $this->view->image ='<img src="http://imagens.fterceiro.pt/media/scope/imagens_ricardo/' .$codF3 . '.jpg" />';
                } else {
                    $this->view->image = '<img src="http://imagens.fterceiro.pt/media/scope/imagens_ricardo/thumb.jpg" />';
                }
                
                
            } else {
                $this->view->errors = $this->form->getMessages();
                $this->view->form = $this->form;
            }
        }

    }

    public function pdfAction ()
    {
        $this->_helper->layout()->disableLayout();
        $formvalues = new RPS_User_Service_ProcessFormValues();
        $formvalues->setAllVars($_POST);
        $data = $formvalues->processData();
        $db = new Application_Model_Boletins();
        $db->insert($data);
        $pdf = new RPS_User_Service_CreatePDF();
        $pdf->setBolID($_POST['id']);
        $pdf->setUser($_POST['password']);
        $this->view->pdf = $pdf->buildPDF();
    }

    public function processAction ()
    {
        $formvalues = new RPS_User_Service_ProcessFormValues();
        $formvalues->setAllVars($_POST);
        $data = $formvalues->processData();
        $db = new Application_Model_Boletins();
        $db->insert($data);
        /**
         * Get Job status
         */
            $obra = $this->_request->getPost('obra');
            $db = new Application_Model_Optimus();
            $job = $db->getJob($obra);
         /**
         * End Job status
         */
        $this->view->jobstatus = $job[0]['j_status'];    
        $this->view->bolid = $this->_request->getPost('id');
        
        
        
        
    }

    public function updateAction ()
    {
        $formvalues = new RPS_User_Service_ProcessFormValues();
        $formvalues->setAllVars($_POST);
        $data = $formvalues->processData();
        $db = new Application_Model_Boletins();
        $db->update($data);
        $this->_helper->flashMessenger->addMessage('success');
        $this->_helper->flashMessenger->addMessage('O Boletim de Análise ' . $_POST['id'] . ' foi actualizado com sucesso.');
        $this->_redirect('/searchdate/' . Zend_Date::now()->toString('YYYY-MM-dd'));
    }

    public function editAction ()
    {
        if ($this->getRequest()->isPost()) {
            $params = $this->_getAllParams();
            $pass = new Application_Model_Passwords();
            $passwd = $pass->getRecords($params['password']);
            if ($passwd['bolanalise'] != 1) {
                $this->_helper->flashMessenger->addMessage('error');
                $this->_helper->flashMessenger->addMessage(
                        'Não tem permissão para aceder a este recurso!');
                switch ($params["type"]) {
                    case 'byjobnumber':
                        $this->_redirect('/search/' . $params['jnumber']);
                        break;
                    case 'bydate':
                        $this->_redirect('/searchdate/' . $params['searchdate']);
                        break;
                    default:
                        $this->_redirect("/");
                        break;
                }
            } else {
                
                $bol = new Application_Model_Boletins();
                $values = $bol->getBoletim($params['bolid']);
                
                
                $form = new Application_Form_Boletim();
                $form->populate($values[0]);
                $this->view->form  = $form;
                $this->view->bolid = $params['bolid'];
            }
            $optimus = new Application_Model_Optimus();
            $this->view->txt1 = $optimus->getJobInfo1($values[0]['obra']);
            $this->view->txt2 = $optimus->getJobInfo2($values[0]['obra']);
            
            $db = new Application_Model_Embalagem();
            $codF3 = $db->getRecordsByJobNumber($values[0]['obra']);
            $codF3 = substr($codF3['codf3'], 0,5);
            
            $url = @getimagesize("http://imagens.fterceiro.pt/media/scope/imagens_ricardo/" . $codF3 . ".jpg");
            
            if (is_array($url)) {
                $this->view->image ='<img src="http://imagens.fterceiro.pt/media/scope/imagens_ricardo/' .$codF3 . '.jpg" />';
            } else {
                $this->view->image = '<img src="http://imagens.fterceiro.pt/media/scope/imagens_ricardo/thumb.jpg" />';
            }   
            
        }
    }

    public function deleteAction ()
    {
        if ($this->getRequest()->isPost()) {
            $params = $this->_getAllParams();
            $pass = new Application_Model_Passwords();
            $passwd = $pass->getRecords($params['password']);
            if ($passwd['bolanalise'] != 1) {
                $this->_helper->flashMessenger->addMessage('error');
                $this->_helper->flashMessenger->addMessage(
                        'Não tem permissão para aceder a este recurso!');
                switch ($params["type"]) {
                    case 'byjobnumber':
                        $this->_redirect('/search/' . $params['jnumber']);
                        break;
                    case 'bydate':
                        $this->_redirect('/searchdate/' . $params['searchdate']);
                        break;
                    case 'byweek':
                        $this->_redirect($params['searchdate']);
                        break;
                    default:
                        $this->_redirect("/");
                        break;
                }
            } else {
                $bol = new Application_Model_Boletins();
                $bol->removeBoletim($params['bolid']);
                $this->_helper->flashMessenger->addMessage('success');
                $this->_helper->flashMessenger->addMessage(
                        'O Boletim Análise Nº' . $params['bolid'] .
                                 ', foi removido com sucesso.');
                switch ($params["type"]) {
                    case 'byjobnumber':
                        $this->_redirect('/search/' . $params['jnumber']);
                        break;
                    case 'bydate':
                        $this->_redirect('/searchdate/' . $params['searchdate']);
                        break;
                    case 'byweek':
                        $this->_redirect($params['searchdate']);
                        break;
                    default:
                        $this->_redirect("/");
                        break;
                }
            }
        }
    }

    public function renderpdfAction ()
    {
        $this->_helper->layout()->disableLayout();
        $id = $this->_getParam('id');
        $bol = new Application_Model_Boletins();
        $row = $bol->getBoletim($id);
        $pass = new Application_Model_Passwords();
        $passwd = $pass->getPasswordByRealName($row[0]['aprovado_por']);
        $pdf = new RPS_User_Service_CreatePDF();
        $pdf->setBolID($id);
        $pdf->setUser($passwd['new_password']);
        $this->view->pdf = $pdf->buildPDF();
    }
}







