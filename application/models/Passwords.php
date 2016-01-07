<?php

class Application_Model_Passwords
{
    public $job;
    
    public function __construct ()
    {
        $config = Zend_Registry::get('passwords');
        $db = Zend_Db::factory($config->database);
        Zend_Db_Table_Abstract::setDefaultAdapter($db);
    
        $this->job = new Application_Model_DbTable_Records();
    }
    
    
    public function getRecords($password)
    {
        $sql = $this->job->select();
        $sql->where('new_password = ?', (int) $password);
        $row = $this->job->fetchRow($sql);
        
        return $row;
    }
    
    
    public function getPasswordByRealName($name)
    {
        $sql = $this->job->select();
        $sql->where('real_name = ?', $name);
        $row = $this->job->fetchRow($sql);
        
        return $row;
    }
    
}

