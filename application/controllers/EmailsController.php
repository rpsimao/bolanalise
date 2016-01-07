<?php

class EmailsController extends Zend_Controller_Action
{

    public function init()
    {
        /* Initialize action controller here */
    }

    public function indexAction()
    {
	    $db = new Application_Model_Emails();
	    $this->view->records = $db->read();
    }



	public function ajaxdeleterecordAction()
	{
		$this->_helper->viewRenderer->setNoRender();
		$this->_helper->layout->disableLayout();

		$id = $this->_getParam('id');

		$db = new Application_Model_Emails();
		$db->delete($id);

	}


	public function ajaxrefreshpageAction()
	{
		$this->_helper->viewRenderer->setRender('index');


		$db = new Application_Model_Emails();
		$this->view->records = $db->read();

	}


	public function ajaxgetallclientsAction()
	{
		$this->_helper->viewRenderer->setNoRender();
		$this->_helper->layout->disableLayout();


		$db = new Application_Model_Boletins();
		$clientes = $db->clientes();

		$db1 = new Application_Model_Emails();
		$ondb = $db1->read();

		$exits = array();

		foreach ($ondb as $cliente){

			$exits[] = $cliente['clientes'];

		}

		$select = '<select id="for-emails-all-clientes">';
		$select.='<option value="">Escolha o cliente:</option>';


		foreach ($clientes as $cliente)
		{
			if(!in_array($cliente['cliente'], $exits)) {
				$select .= '<option value="' . $cliente['cliente'] . '">' . $cliente['cliente'] . '</option>';
			}
		}

		$select.='</select>';


		$this->getResponse()->appendBody($select);


	}



	public function ajaxinsertnewAction()
		{

			$this->_helper->viewRenderer->setNoRender();
			$this->_helper->layout->disableLayout();

			$values = $this->getAllParams();

			$db = new Application_Model_Emails();
			$db->create($values['cliente'], $values['emails']);

		}


	public function ajaxupdateAction()
	{

		$this->_helper->viewRenderer->setNoRender();
		$this->_helper->layout->disableLayout();

		$values = $this->getAllParams();
		$db = new Application_Model_Emails();
		$db->update($values['id'], $values['emails']);

	}


	public function ajaxfindAction()
	{
		$this->_helper->viewRenderer->setNoRender();
		$this->_helper->layout->disableLayout();

		$id = $this->_getParam('id');

		$db = new Application_Model_Emails();
		$values = $db->find($id);

		$this->getResponse()->appendBody($values[0]['emails']);


	}


}

