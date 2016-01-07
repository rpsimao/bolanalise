<?php
class RPS_User_Service_Mail
{
   // const EMAIL_1 = 'acatarino@bluepharma.pt';
    //const EMAIL_2 = 'jjorge@bluepharma.pt';

   // const EMAIL_4 = 'francisco.figueiredo@fterceiro.pt';
    
    /*const EMAIL_1 = 'ricardo.simao@fterceiro.pt';
    const EMAIL_2 = 'ricardo.simao@fterceiro.pt';
    const EMAIL_3 = 'ricardo.simao@fterceiro.pt';
    const EMAIL_4 = 'ricardo.simao@fterceiro.pt';*/
    
     
   // const NOME_1 = "Ana Patrícia Catarino";
    //const NOME_2 = "Joana Balhau Jorge";

    //const NOME_4 = "Francisco Figueiredo";

	/**
	 * O sistema já permite enviar Bol de análise para qq cliente.
	 * A única constante agora utilizada é do utilizador interno.
	 * @to-do passar o user(s) da F3 para o Frontend, para não ser preciso mais mexer no código
	 */

	const NOME_3 = "Carina Santos";
	const EMAIL_3 = 'carina.santos@fterceiro.pt';

    /**
     * Guarda as configurações do ficheiro de configuração
     *
     * @var Zend_Config_Ini
     */
    protected $config;
    /**
     * Parametros de autenticação do servidor de email
     *
     * @var string
     */
    protected $params;
    /**
     * Insere os dados de autenticação
     *
     * @var Zend_Mail_Transport_Smtp
     */
    protected $transport;
    /**
     * Tipo de Contacto
     *
     * @var string
     */
    private $type;
    private $typeOfContact;
    private $InternalOptions;
    protected $attach;
    protected $boldetails;

	private $emails;
    /**
     *
     * @return Zend_Mail_Transport_Smtp
     */
    private function setTransport ()
    {
        $this->config = Zend_Registry::get('mail_server');
        $this->params = array('auth' => 'login', 
        'username' => $this->config->username, 
        'password' => $this->config->password, 'ssl' => 'tls', 'port' => 25);
        $this->transport = new Zend_Mail_Transport_Smtp($this->config->ip_dns, 
        $this->params);
        return $this->transport;
    }
    /**
     *
     * @param unknown_type $params            
     */
    public function setAttachment ($params)
    {
        $this->attach = $params;
    }
    /**
     *
     * @return unknown_type
     */
    private function _getAttach ()
    {
        return $this->attach;
    }
    /**
     *
     * @param array $params            
     */
    public function setBoletimDetails (array $params)
    {
        $this->boldetails = $params;
    }
    /**
     *
     * @return multitype:
     */
    private function _getBolDetails ()
    {
        return $this->boldetails;
    }
    /**
     */


	public function setDestinations($emails)
	{
		$this->emails = $emails;

	}

	private function _getDestinations()
	{

		$emails = explode(";", $this->emails);


		return $emails;

	}


    public function sendMail ()
    {
        $boletim = $this->_getBolDetails();
        $mail = new Zend_Mail($charset = 'UTF-8');
        $mail->setBodyHtml($this->_emailBody());
        $mail->setFrom('carina.santos@fterceiro.pt', 'Carina Santos');
        //$mail->addTo( array(self::NOME_1 => self::EMAIL_1, self::NOME_2 => self::EMAIL_2));
        //$mail->addCc(array(self::NOME_4 => self::EMAIL_4));
	    $mail->addTo($this->_getDestinations());
        $mail->addBcc(array(self::NOME_3 => self::EMAIL_3));
        $mail->setSubject(
        'Bol. Análise ' . $boletim['nomecx'] . ' - Ordem Compra: ' .
         $boletim['ordemcompra']);
        $mail->setType(Zend_Mime::MULTIPART_RELATED);
        /**
         * Define attachment
         */
        $filepath = "/tmp/" . $this->_getAttach() . ".pdf";
        $fileContents = file_get_contents($filepath);
        $file = $mail->createAttachment($fileContents);
        $filename = "Bol" . $boletim['id'] . '.pdf';
        $file->filename = $filename;
        $mail->send($this->setTransport());
        unlink($filepath);
    }
    private function _emailBody ()
    {
        $time = Zend_Date::now()->toString('HH');
        $boletim = $this->_getBolDetails();
        $salut = ($time < 12) ? "Bom dia" : "Boa Tarde";
        $html = '<p style="font-size:12px;font-family:Arial, Helvetica, Geneva, sans-serif;">' .
        $salut . "</p>";
        $html .= '<p style="font-size:12px;font-family:Arial, Helvetica, Geneva, sans-serif;">Em anexo o Boletim de Análise referente à v/ O/C: ' .
        $boletim['ordemcompra'] . " do código: " . $boletim['codigo'] . ".</p>";
        $html .= '<p style="font-size:12px;font-family:Arial, Helvetica, Geneva, sans-serif;">Melhores Cumprimentos</p>';
        $html .= '<p style="font-size:12px;font-family:Arial, Helvetica, Geneva, sans-serif;">Carina Santos | Controladora de Qualidade, Ambiente e Segurança</p>';
        $html .= '<p style="font-size:12px;font-family:Arial, Helvetica, Geneva, sans-serif;"><span style="color:green;font-size:95%;">Fernandes & Terceiro, S.A.<br></span>';
        $html .= '<span style="font-size:95%;">carina.santos@fterceiro.pt  |  Tel. +351 214 259 200  |  Fax: +351 214 259 201</span></p>';
        return $html;
    }
}