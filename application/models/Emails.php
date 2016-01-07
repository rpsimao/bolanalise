<?php

class Application_Model_Emails
{

	protected $clientes;

	public function __construct ()
	{
		$config = Zend_Registry::get('boletins');
		$db = Zend_Db::factory($config->database);
		Zend_Db_Table_Abstract::setDefaultAdapter($db);
		$this->clientes = new Application_Model_DbTable_Contactos();
	}


	/**
	 * @param int $id
	 * @return array
	 * @throws Zend_Db_Table_Exception
	 */
	public function find($id)
	{
		$row = $this->clientes->find($id);
		return $row->toArray();
	}


	public function listNamesWithEmail()
	{
		$rows = $this->clientes->getAdapter()->fetchAll('SELECT * FROM contactos WHERE emails IS NOT NULL AND TRIM(clientes) <> ""');
		return $rows;
	}

	/**
	 * @return Zend_Db_Table_Rowset_Abstract
	 */

	public function read()
	{
		$sql = $this->clientes->select();
		$rows = $this->clientes->fetchAll($sql);
		return $rows;

	}

	/**
	 * @param string $cliente
	 * @param string $emails
	 */

	public function create($cliente, $emails)
	{
		$this->clientes->insert(
			array(
					"clientes" => $cliente,
					"emails"   => $emails
			)

		);

	}

	/**
	 * @param int $id
	 * @param string $cliente
	 * @param string $emails
	 */
	public function update($id, $emails)
	{

		$where = $this->clientes->getAdapter()->quoteInto('id = ?', $id);
		$this->clientes->update(
			array(
				'emails'=>$emails)
			, $where
			);

	}

	/**
	 * @param int $id
	 */
	public function delete($id)
	{
		$where = $this->clientes->getAdapter()->quoteInto('id = ?', $id);
		$this->clientes->delete($where);
	}


	public function getEmails($cliente)
	{

		$sql = $this->clientes->select();
		$sql->where("clientes = ?", $cliente);
		$row = $this->clientes->fetchRow($sql);

		return $row;

	}


	public function findCliente($cliente)
	{

		$sql = $this->clientes->select();
		$sql->where("clientes = ?", $cliente);
		$row = $this->clientes->fetchRow($sql);

		if ($row){

			return TRUE;
		}

	}



}

