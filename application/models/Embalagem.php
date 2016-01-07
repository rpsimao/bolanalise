<?php

class Application_Model_Embalagem
{
    protected $emb;
    /**
     */
    public function __construct ()
    {
    $config = Zend_Registry::get('embalagem');
    $db = Zend_Db::factory($config->database);
    Zend_Db_Table_Abstract::setDefaultAdapter($db);
    $this->emb = new Application_Model_DbTable_Obras();
    }
    
    
    public function getRecordsByJobNumber($jnumber)
    {
        $sql = $this->emb->select();
        $sql->where('obra = ?', $jnumber);
        $row = $this->emb->fetchRow($sql);
        
        return $row;
        
    }

}

