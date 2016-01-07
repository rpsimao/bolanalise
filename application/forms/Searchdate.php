<?php

class Application_Form_Searchdate extends Zend_Form
{

    public function init()
    {
        $this->setAction('/searchdate')->setMethod('POST');
        $this->setAttrib('class', 'navbar-search pull-right');
        $this->setDecorators(array('FormElements','Form'));
       
        $decorators = array(
        array(
        'ViewHelper') ,
        array(
        'Errors') ,
        array(
        'Label') ,
        array(
        'HtmlTag' ,
        array(
        'tag' => 'li')));
        
        $date = new Zend_Form_Element_Text('navbardateform');
        $date->setRequired(TRUE);
        $date->addValidator(new Zend_Validate_Date());
        $date->setAttribs(array('class' => 'search-query size-20', "placeholder" => "Procurar por data", 'onchange' => "triggerdate()"));
        $date->setDecorators($decorators);
        $this->addElement($date);
    }
}
