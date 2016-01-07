<?php
/**
 *
 * @author rpsimao
 *        
 */
class RPS_Views_Helper_Flashinfo extends Zend_View_Helper_Abstract
{
    
    const ALERT_ERROR  = "alert alert-error";
    const ALERT_INFO   = "alert alert-info";
    const ALERT_SUCCESS = "alert alert-success";
    const ICON_OK      = "icon-ok-sign";
    const ICON_INFO    = "icon-info-sign";
    const ICON_ERROR   = "icon-exclamation-sign";
    
   
    
    
    public function Flashinfo($mode, $msg)
    {
        
        switch ($mode) {
            case "error":
                return $this->_htmlcode(array('divclass' => self::ALERT_ERROR, 'iconclass' => self::ICON_ERROR, 'msg' => $msg));
            break;
            
            case "success":
                return $this->_htmlcode(array('divclass' => self::ALERT_SUCCESS, 'iconclass' => self::ICON_OK, 'msg' => $msg));
            break;
                
            case "info":
                 return $this->_htmlcode(array('divclass' => self::ALERT_INFO, 'iconclass' => self::ICON_INFO, 'msg' => $msg));
            break;
            
        }
        
        
    }
    
    
    private function _htmlcode(array $info)
    {
        $html =  '<div class="'.$info["divclass"].'" id="default_flash_message"><button type="button" class="close" data-dismiss="alert">×</button><p><i class="'.$info["iconclass"].'"></i><b> '.$info["msg"].'</b></p></div>';

        return $html;
    
    }
        
        
}
    
