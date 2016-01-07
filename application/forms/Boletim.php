<?php

class Application_Form_Boletim extends Zend_Form
{

    public function init()
    {
        $element = new Zend_Form_Element_Text('obra');
        $this->addElement($element);
        
        $element = new Zend_Form_Element_Text('cliente');
        $this->addElement($element);
        
        $element = new Zend_Form_Element_Text('quantidade');
        $this->addElement($element);
        
        $element = new Zend_Form_Element_Text('produto');
        $this->addElement($element);
        
        $element = new Zend_Form_Element_Text('codigo');
        $this->addElement($element);
        
        $element = new Zend_Form_Element_Text('encomenda');
        $this->addElement($element);
        
        $element = new Zend_Form_Element_Text('tipo_txt');
        $this->addElement($element);
        
        $element = new Zend_Form_Element_Checkbox('tipo');
        $this->addElement($element);
        
        $element = new Zend_Form_Element_Text('gramagem_txt');
        $element->setFilters(array(new Zend_Filter_Digits()));
        $this->addElement($element);
        
        $element = new Zend_Form_Element_Checkbox('gramagem');
        $this->addElement($element);
        
        $element = new Zend_Form_Element_Text('espessura_txt');
        $this->addElement($element);
        
        $element = new Zend_Form_Element_Checkbox('espessura');
        $this->addElement($element);
        
        $element = new Zend_Form_Element_Checkbox('fibra');
        $this->addElement($element);
        
        $element = new Zend_Form_Element_Checkbox('texto');
        $this->addElement($element);
        
        $element = new Zend_Form_Element_Text('cores_txt');
        $this->addElement($element);
        
        $element = new Zend_Form_Element_Checkbox('cores');
        $this->addElement($element);
        
        $element = new Zend_Form_Element_Checkbox('verniz');
        $this->addElement($element);
        
        $element = new Zend_Form_Element_Checkbox('qualidade_impressao');
        $this->addElement($element);
        
        $element = new Zend_Form_Element_Checkbox('codigo_barras');
        $this->addElement($element);
        
        $element = new Zend_Form_Element_Checkbox('codigo_laetus');
        $this->addElement($element);
        
        $element = new Zend_Form_Element_Checkbox('tinta_reactiva');
        $this->addElement($element);
        
        $element = new Zend_Form_Element_Checkbox('codigo_descodificador');
        $this->addElement($element);
        
        $element = new Zend_Form_Element_Checkbox('qualidade_corte_vinco');
        $this->addElement($element);
        
        $element = new Zend_Form_Element_Text('dimensoes_cartonagem_txt');
        $element->setFilters(array(new Zend_Filter_StringTrim()));
        $this->addElement($element);
        
        $element = new Zend_Form_Element_Checkbox('dimensoes_cartonagem');
        $this->addElement($element);
        
        $element = new Zend_Form_Element_Checkbox('braille');
        $this->addElement($element);
        
        $element = new Zend_Form_Element_Checkbox('qualidade_colagem');
        $this->addElement($element);
        
        $element = new Zend_Form_Element_Checkbox('funcionamento_cartonagem');
        $this->addElement($element);
        
        $element = new Zend_Form_Element_Checkbox('friccao');
        $this->addElement($element);
        
        $element = new Zend_Form_Element_Checkbox('condicoes_acondicionamento');
        $this->addElement($element);
        
        $element = new Zend_Form_Element_Checkbox('informacao_rotulo');
        $this->addElement($element);
        
        $element = new Zend_Form_Element_Checkbox('aprovado');
        $this->addElement($element);
        
        $element = new Zend_Form_Element_Text('data');
        $this->addElement($element);
        
        $element = new Zend_Form_Element_Text('aprovado_por');
        $this->addElement($element);
        
        $element = new Zend_Form_Element_Text('embalagens_inspeccionadas');
        $this->addElement($element);
        
        $element = new Zend_Form_Element_Text('defeitos_maiores');
        $this->addElement($element);
        
        $element = new Zend_Form_Element_Text('defeitos_menores');
        $this->addElement($element);
        
        $element = new Zend_Form_Element_Textarea('obs');
        $element->setAttribs(array('cols'=> 5, 'rows'=>10));
        $this->addElement($element);
        
        $element = new Zend_Form_Element_Hidden('id');
        $this->addElement($element);
        
        $element = new Zend_Form_Element_Hidden('password');
        $this->addElement($element);
        
        $submit = new Zend_Form_Element_Submit('submit');
        $submit->setLabel('Actualizar Boletim de Análise');
        $submit->setAttrib('class', 'btn btn-primary');
        $this->addElement($submit);
        
     foreach($this->getElements() as $element)
        {
            $element->removeDecorator('Label');
            $element->removeDecorator('DtDdWrapper');
        }
    }


}

