<?php

class RPS_Views_Helper_Bluephramaalert
{

    /**
     *
     * @var Zend_View_Interface
     */
    public $view;

    /**
     */
    public function Bluephramaalert ($param1, $param2)
    {
        if ($param1 > $param2) {
            $html = '<div id="msg" style="display: block;" class="alert alert-info">';
            $html .= '<button type="button" class="close" data-dismiss="alert">×</button>';
            $mail = $param1 - $param2;
            $html .= '<i class="icon-info-sign sz-14"></i> ';
            $html .= 'Tem ' . $mail . ' mail(s) para enviar à Bluepharma. <a href="/search/bp/index/">[ VER ]</a></div>';
            return $html;
        }
        
       
    }

    /**
     * Sets the view field
     *
     * @param $view Zend_View_Interface            
     */
    public function setView (Zend_View_Interface $view)
    {
        $this->view = $view;
    }
}
