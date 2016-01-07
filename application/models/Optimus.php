<?php

class Application_Model_Optimus
{
    protected $job;
    protected $customers;
    
    public function __construct ()
    {
        $config = Zend_Registry::get('optimus');
        $db = Zend_Db::factory($config->database);
        Zend_Db_Table_Abstract::setDefaultAdapter($db);
        
        $this->job = new Application_Model_DbTable_Job();
        $this->customers = new Application_Model_DbTable_Customers();
    }
    
    public function getJob($jnumber)
    {
        $row = $this->job->find((int) $jnumber);
        return $row->toArray();
    }
    
    
    public function getCustomers($code)
    {
        $row = $this->customers->find($code);
        return $row->toArray();
    }
    
    
    /**
     * Retorna o 1 campo de informação da folha de obra
     * @param int $numObra
     * @return array
     */
    public function getJobInfo1 ($numObra)
    {
    
        $row = $this->job->getAdapter()->fetchRow('SELECT jdoc.sect_text FROM jtx INNER JOIN jdoc ON jtx.idnum = jdoc.id WHERE (((jtx.jobnum)=?) AND ((jtx.type)="T"));', $numObra);
        return $row;
    }
    
    /**
     * Retorna o 2 campo de informação da folha de obra
     * @param int $numObra
     * @return array
     */
    public function getJobInfo2 ($numObra)
    {
    
        $row = $this->job->getAdapter()->fetchRow('SELECT jdoc.sect_text FROM jtx INNER JOIN jdoc ON jtx.idnum = jdoc.id WHERE (((jtx.jobnum)=?) AND ((jtx.type)="S") AND ((jtx.code)="job"));', $numObra);
        return $row;
    }

}

