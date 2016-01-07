<?php
class Application_Model_Boletins
{
    protected $bols;
    /**
     */
    public function __construct ()
    {
        $config = Zend_Registry::get('boletins');
        $db = Zend_Db::factory($config->database);
        Zend_Db_Table_Abstract::setDefaultAdapter($db);
        $this->bols = new Application_Model_DbTable_Analise();
    }
    /**
     *
     * @param string $bolnumber            
     * @return multitype:
     */
    public function getBoletim ($bolnumber)
    {
        $row = $this->bols->find($bolnumber);
        return $row->toArray();
    }
    
    /**
     *
     * @param string $id            
     * @param string $field            
     * @return number
     */
    public function TrueOrFalse ($id, $field)
    {
        $data = $this->getBoletim($id);
        $v = ($data[0][$field] == 1) ? 1 : 0;
        return $v;
    }
    /**
     *
     * @param int $jobnumber            
     * @return Zend_Db_Table_Rowset_Abstract
     */
    public function getAllBoletinsByJobNumber ($jobnumber)
    {
        $sql = $this->bols->select();
        $sql->where('obra =?', (int) $jobnumber);
        $rows = $this->bols->fetchAll($sql);
        return $rows;
    }
    /**
     *
     * @param array $values            
     */
    public function insert (array $values)
    {
        $this->bols->insert($values);
    }
    
    /**
     * Delete record
     * @param string $id
     */
    public function removeBoletim($id)
    {
        $where = $this->bols->getAdapter()->quoteInto('id = ?', $id);
        $this->bols->delete($where);
    }
    
    public function update(array $values)
    {
        $where = $this->bols->getAdapter()->quoteInto('id = ?', $values['id']);
        $this->bols->update($values, $where);
    }
    
    public function searchByDate($date)
    {
        $sql = $this->bols->select();
        $sql->where('data = ?', $date);
        $sql->order('cliente');
        $rows = $this->bols->fetchAll($sql);
        return $rows;
    }
    
    public function getSemana()
    {
        $rows = $this->bols->getAdapter()->fetchAll('SELECT * FROM analise WHERE YEARweek(data) = YEARweek(current_DATE) order by cliente');
        return $rows;
    }
    
    public function getMes()
    {
        $rows = $this->bols->getAdapter()->fetchAll('SELECT * FROM analise WHERE YEAR(data) = YEAR(CURDATE()) AND MONTH(data) = MONTH(CURDATE()) order by `datetime`');
        return $rows;
    }
    
    
    public function getYear()
    {
        $currentYear = Zend_Date::now()->toString("YYYY");
        
        $sql = $this->bols->select();
        $sql->where("YEAR(data) = ? ", (int) $currentYear);
        $sql->order("datetime");
        
        $rows = $this->bols->fetchAll($sql);
        return $rows;
    }
    
    public function getBolByOC($oc)
    {
        $sql = $this->bols->select();
        $sql->where('encomenda = ?', $oc);
        $sql->order('codigo');
        $rows = $this->bols->fetchAll($sql);
        return $rows;
        
    }
    
    public function getAllByClient($client)
    {
        $sql = $this->bols->select();
        $sql->where('cliente = ?', $client);
        $rows = $this->bols->fetchAll($sql);
        
        foreach ($rows as $value) 
        {
          $yu[] = $value['id'];
        }
        
        return $yu;
    }
    
    public function getAllBP()
    {
        $sql = $this->bols->select();
        $sql->where('cliente = "Bluepharma-Ind. Farmac. SA"');
        $sql->order('datetime DESC');
        $rows = $this->bols->fetchAll($sql);
    
        return $rows;
    }
    
    public function filterBluepharmaMail()
    {
        
        $rows = $this->bols->getAdapter()->fetchAll('select id, cliente, produto from analise where cliente = "Bluepharma-Ind. Farmac. SA" and id not in (select bolid from mail) ');
        return $rows;
        
    }


	/**
	 * @return Zend_Db_Table_Rowset_Abstract
	 */

	public function clientes()
	{
		$sql = $this->bols->select();
		$sql->group("cliente");
		$sql->order("cliente ASC");

		$rows = $this->bols->fetchAll($sql);
		return $rows;

	}




    
   
    
}

