<?php
class Application_Model_TM
{
    protected $table;
    /**
     * 
     */
    public function __construct ()
    {
        $config = Zend_Registry::get('optimus');
        $db = Zend_Db::factory($config->database);
        Zend_Db_Table_Abstract::setDefaultAdapter($db);
        $this->table = new Application_Model_DbTable_TM();
    }
    /**
     * 
     * @param int $jnumber
     * @return number
     */
    public function getQtyMachine112 ($jnumber)
    {
        $sql = $this->table->select();
        $sql->where('tm_job = ?', (int) $jnumber);
        $sql->where("tm_act like '112 COL%'");
        $rows = $this->table->fetchAll($sql);
        $qty = $this->_sumQty($rows);
        return $qty;
    }
    /**
     * 
     * @param Zend_Db_Rows $rows
     * @return number
     */
    private function _sumQty($rows)
    {
        foreach ($rows as $qty) {
            $val[] = $qty['tm_good_qty'];
        }
        $qty = array_sum($val);
        return $qty;
    }
}

