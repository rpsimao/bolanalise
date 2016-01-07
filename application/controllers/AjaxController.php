<?php

class AjaxController extends Zend_Controller_Action
{

    public function init()
    {
        $this->_helper->layout()->disableLayout();
        $this->_helper->viewRenderer->setNoRender(true);
    }

    public function indexAction(){}

    public function imagesAction()
    {
        $jnumber = $this->_getParam('jnumber');
        $db = new Application_Model_Embalagem();
        $cod = $db->getRecordsByJobNumber($jnumber);
        
        if ($cod == NULL)
        {
            $ch = curl_init("http://embalagem.intranet.fterceiro.pt/obra?id=$jnumber&tipo=optimus");
            curl_exec($ch);
            curl_close($ch);
            
            $cod = $db->getRecordsByJobNumber($jnumber);
        }

        $codF3 = ($cod['codf3'] > 10) ? $cod['codf3'] : "";

        $result = substr($cod['codf3'], 0, 5);

        $url = @getimagesize("http://imagens.fterceiro.pt/media/scope/imagens_ricardo/".$result .".jpg");
        
        if (is_array($url))
        {
            $this->getResponse()->appendBody('<div class="well well-small"><p><b>Cód. F3:</b> '.$codF3.'<b>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Obra Nº:</b> '.$jnumber.'</p></div><img class="img-polaroid" src="http://imagens.fterceiro.pt/media/scope/imagens_ricardo/'.$result.'.jpg" />');
        } else {
            $this->getResponse()->appendBody('<div class="well well-small"><p><b>Cód. F3:</b> '.$codF3.'<b>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Obra Nº:</b> '.$jnumber.'</p></div><img class="img-polaroid" src="http://imagens.fterceiro.pt/media/scope/imagens_ricardo/thumb.jpg" />');
        }
    }

    public function getf3codeAction()
    {
        $jnumber = $this->_getParam('jnumber');
        $db = new Application_Model_Embalagem();
        $cod = $db->getRecordsByJobNumber($jnumber);
        $this->getResponse()->appendBody($cod['codf3']);
    }

    public function getpackinfoAction()
    {
        $jnumber = $this->_getParam('jnumber');
        $db = new Application_Model_Embalagem();
        $info = $db->getRecordsByJobNumber($jnumber);
        $this->getResponse()->appendBody($info);
    }

    public function verifyAction()
    {
        $params = $this->getAllParams();
        $obra = $params['job'];
        
        $optimus = new Application_Model_Optimus();
        $txt1 = $optimus->getJobInfo1($obra);
        $txt2 = $optimus->getJobInfo2($obra);
        
        preg_match("/cores:(.+)/i", $txt2['sect_text'], $match);
        $cores = str_ireplace('cores:', '', $match[0]);
        $cores = str_replace(' ', '', $cores);
        $cores = strtoupper($cores);
        $cores = preg_replace('/[ ]{2,}|[\t]/', ' ', trim($cores));
        
        $cores = ($cores == "CMYK") ? "C+M+Y+K" : $cores;
        
       // $tamanho = preg_match("/fechado: [0-9 *]+(?:\.[0-9]*)?+(?:\,[0-9]*)?/i", $txt1['sect_text'], $match);
        preg_match("/fechado:(.+)/i", $txt1['sect_text'], $match);
        $clean1  = str_ireplace("fechado:", "", $match[0]);
        $clean1  = preg_replace('/[ ]{2,}|[\t]/', ' ', trim($clean1));
        $clean1  = str_ireplace("mm.", "", $clean1);
        $clean1  = str_ireplace("mm", "", $clean1);
        $clean1  = str_replace(' ', '', $clean1);
        $tamanho = str_replace('*', 'x', $clean1);
        
        $this->getResponse()->appendBody(strtoupper($cores) . "-" . $tamanho);
    }

    public function optimustxt1Action()
    {
        $params = $this->getAllParams();
        $obra = $params['job'];
        $data = $params['d'];
        
        $optimus = new Application_Model_Optimus();
        $txt1 = $optimus->getJobInfo1($obra);
        
        //$tamanho = preg_match("/formato fechado: [0-9 *]+(?:\.[0-9]*)?+(?:\,[0-9]*)?/i", $txt1['sect_text'], $match);
        preg_match("/fechado:(.+)/i", $txt1['sect_text'], $match);
        $clean1 = str_ireplace("fechado:", "", $match[0]);
        $clean1 = preg_replace('/[ ]{2,}|[\t]/', ' ', trim($clean1));
        $clean1 = str_ireplace("mm.", "", $clean1);
        $clean1 = str_ireplace("mm", "", $clean1);
        $clean1 = str_replace(' ', '', $clean1);
        $valuesOpt = explode("*", $clean1);
        $valuesForm = explode("x", $data);
        $i = 0;
        $return = "Formato fechado: ";
        
        foreach ($valuesOpt as $value) {
            
            if ($value != $valuesForm[$i]) {
                
                $return .= '<span class="txt_errors">' . $value . '</span>x';
            } else {
                
                $return .= $value . "x";
            }
            
            $i ++;
        }
        
        $this->getResponse()->appendBody(utf8_encode(substr($return, 0, - 1)));
    }

    public function optimustxt2Action()
    {
        $params = $this->_getAllParams();
        $obra = $params['job'];
        $data = $params['d'];
        $data = strtoupper($data);
        
        $db = new Application_Model_Embalagem();
        $codF3 = $db->getRecordsByJobNumber($obra);
        $codF3 = substr($codF3['codf3'], 0, 5);
        
        $optimus = new Application_Model_Optimus();
        $txt2 = $optimus->getJobInfo2($obra);
        $txt2 = strtoupper($txt2['sect_text']);
        
        $cores = preg_match("/cores:(.+)/i", $txt2, $match);
        $clean1 = str_ireplace("cores:", "", $match[0]);
        $clean2 = str_replace(" ", "", $clean1);
        $toUp = strtoupper($clean2);
        $toUp = preg_replace('/[ ]{2,}|[\t]/', ' ', trim($toUp));
        
        if ($toUp == "CMYK") {
            
            $valuesOpt = array(
                    0 => "C",
                    1 => "M",
                    2 => "Y",
                    3 => "K"
            );
        } else {
            
            $valuesOpt = explode("+", $toUp);
        }
        
        $valuesForm = explode("*", $data);
        
        $i = 0;
        $startDiv = '<div class="optimus_txt2">';
        $endDiv = "</div>";
        $return = '<b>Cores:</b> ';
        
        foreach ($valuesOpt as $value) {
            
            if ($value != $valuesForm[$i]) {
                
                $return .= '<span class="txt_errors">' . $value . '</span>+';
            } else {
                
                $return .= $value . "+";
            }
            
            $i ++;
        }
        
        $url = @getimagesize(
                "http://imagens.fterceiro.pt/media/scope/imagens_ricardo/" .
                         $codF3 . ".jpg");
        
        if (is_array($url)) {
            $image = '<br /><br /><img class="img-polaroid" src="http://imagens.fterceiro.pt/media/scope/imagens_ricardo/' .
                     $codF3 . '.jpg" />';
        } else {
            $image = "";
        }
        
        $this->getResponse()->appendBody(utf8_encode($startDiv. substr($return, 0, -1). $image . $endDiv));
        
       
    }

    public function checkpasswdinitAction()
    {
        $passwd = $this->_getParam("p");
        $val = new RPS_User_Service_CheckPassword();
        $resp = $val->check($passwd);
        
        $this->getResponse()->appendBody($resp);
        
    }

    public function gettodayAction()
    {
        $today = Zend_Date::now()->toString('ddMMYY');
        $this->getResponse()->appendBody($today);
    }

    public function validatepasswdAction()
    {
        // action body
    }


}











