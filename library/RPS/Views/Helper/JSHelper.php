<?php
class RPS_Views_Helper_JSHelper extends Zend_View_Helper_Abstract
{
    function JSHelper ()
    {
        $request = Zend_Controller_Front::getInstance()->getRequest();
        $file_uri = 'js/' . $request->getControllerName() . '/' .
         $request->getActionName() . '.js';
        if (file_exists($file_uri)) {
           return '<script type="text/javascript" src="'.'/' . $file_uri.'"></script>';
        }
    }
}