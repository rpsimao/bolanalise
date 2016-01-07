<?php

class RPS_Validators_Initformpassword extends Zend_Validate_Abstract
{

    const PASSWD_ERROR= 'passworderror';
    
    private $db;

    protected $_messageTemplates = array(
        self::PASSWD_ERROR => 'A password não é válida para este recurso.',
        
        );

    private function _conn()
    {
        $this->db = Zend_Registry::get('passwords');
        $conn = Zend_Db::factory($this->db->database);

        return $conn;
    }

    
    
    
    public function isValid ($value)
    {

        $conn = $this->_conn()->fetchRow('SELECT bolanalise FROM records WHERE new_password = ?', $value);
        
        if ($conn['bolanalise'] != 1)
        {
            $this->_error(self::PASSWD_ERROR);
            return FALSE;
        } else {
            return TRUE;
        }
    }
}
?>