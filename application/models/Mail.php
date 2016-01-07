<?php
class Application_Model_Mail
{
    protected $values;
    protected $mail;
    /**
     * Set DB Adapter
     */
    public function __construct ()
    {
        $config = Zend_Registry::get('boletins');
        $db = Zend_Db::factory($config->database);
        Zend_Db_Table_Abstract::setDefaultAdapter($db);
        $this->mail = new Application_Model_DbTable_Email();
    }
    /**
     * Set Values 
     * @param string bolid
     * @param int enviado
     * @param array $params
     */
    public function setValues (array $params)
    {
        $this->values = $params;
    }
    /**
     * get values
     * @return multitype:
     */
    private function getValues ()
    {
        return $this->values;
    }
    /**
     * Set email status
     */
    public function setEmailStatus ()
    {
        $this->mail->insert($this->getValues());
    }
    /**
     * Get email status
     * @param string $bolid
     * 
     */
    public function getEmailStatus ($bolid)
    {
        $sql = $this->mail->select();
        $sql->where('bolid = ?', $bolid);
        $row = $this->mail->fetchRow($sql);
        return $row['enviado'];
    }

	/**
	 * How many records exists
	 * @return int
	 */
    public function countBoletins()
    {
        
        $rows = $this->mail->fetchAll();
        return count($rows);
    }





}

