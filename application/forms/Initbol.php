<?php

class Application_Form_Initbol extends Zend_Form
{

    public function init()
    {
       $config = Zend_Registry::get('optimus');
       $db = Zend_Db::factory($config->database);
        
       $this->setAction("/boletim");
       $this->setMethod("POST");
       
       $password = new Zend_Form_Element_Password('password');
       $password->setLabel('Password:');
       $password->setRequired(TRUE);
       $password->setAttribs(array('placeholder' => "Insira a sua password"));
       $password->addValidators(array(new RPS_Validators_Initformpassword(), new Zend_Validate_Int()));
       $this->addElement($password);
       
       $bolanalise = new Zend_Form_Element_Text('bolanalise');
       $bolanalise->setLabel('Nº boletim Análise:');
       $bolanalise->setRequired(TRUE);
       $bolanalise->setAttribs(array('placeholder' => "Insira o nº boletim"));
       $bolanalise->addValidator(new Zend_Validate_Db_NoRecordExists(array('table'=>'analise', 'field'=>'id')));
       //$bolanalise->addErrorMessage("Já existe este boletim.");
       $this->addElement($bolanalise);
       
       $obra = new Zend_Form_Element_Text('obra');
       $obra->setLabel('Nº Obra:');
       $obra->setRequired(TRUE);
       $obra->setAttribs(array('placeholder' => "Insira o nº obra"));
       $obra->addValidator(new Zend_Validate_Db_RecordExists(array('table'=>'job', 'field'=>'j_number','adapter'=>$db)));
        //->addErrorMessage("Não foi encontrada uma obra com o Nº %value%");
       $this->addElement($obra);
       
       $submit = new Zend_Form_Element_Submit('submit');
       $submit->setLabel('Enviar');
       $submit->setAttrib('class', 'btn btn-primary');
       $this->addElement($submit);
    }


}

