<?php
/** 
 * @author rpsimao
 * 
 */
class RPS_User_Service_ProcessFormValues
{
    public $postvars;
    
    /**
     * 
     * @param unknown_type $postvars
     */
    public function setAllVars($postvars)
    {
        $this->postvars = $postvars;
    }
    /**
     * 
     * @return unknown_type
     */
    private function _getAll()
    {
        return $this->postvars;
    }
    
    
    /**
     * 
     * @param string $var
     * @return multitype:unknown
     */
    private function _arrayInsertDB ($var)
    {
        $preg = array($var => $_POST[$var]);
        return $preg;
    }
   
    
    public function processData()
    {
        
        $data = $this->_arrayInsertDB('id');
        $data = array_merge($data, $this->_arrayInsertDB('obra'));
        $data = array_merge($data, $this->_arrayInsertDB('cliente'));
        $data = array_merge($data, $this->_arrayInsertDB('quantidade'));
        $data = array_merge($data, $this->_arrayInsertDB('produto'));
        $data = array_merge($data, $this->_arrayInsertDB('encomenda'));
        $data = array_merge($data, $this->_arrayInsertDB('codigo'));
        $data = array_merge($data, $this->_arrayInsertDB('tipo'));
        $data = array_merge($data, $this->_arrayInsertDB('tipo_txt'));
        $data = array_merge($data, $this->_arrayInsertDB('gramagem'));
        $data = array_merge($data, $this->_arrayInsertDB('gramagem_txt'));
        $data = array_merge($data, $this->_arrayInsertDB('espessura'));
        $data = array_merge($data, $this->_arrayInsertDB('espessura_txt'));
        $data = array_merge($data, $this->_arrayInsertDB('fibra'));
        $data = array_merge($data, $this->_arrayInsertDB('texto'));
        $data = array_merge($data, $this->_arrayInsertDB('cores'));
        $data = array_merge($data, $this->_arrayInsertDB('cores_txt'));
        $data = array_merge($data, $this->_arrayInsertDB('verniz'));
        $data = array_merge($data, $this->_arrayInsertDB('qualidade_impressao'));
        $data = array_merge($data, $this->_arrayInsertDB('codigo_barras'));
        $data = array_merge($data, $this->_arrayInsertDB('codigo_laetus'));
        $data = array_merge($data, $this->_arrayInsertDB('tinta_reactiva'));
        $data = array_merge($data, $this->_arrayInsertDB('codigo_descodificador'));
        $data = array_merge($data, $this->_arrayInsertDB('qualidade_corte_vinco'));
        $data = array_merge($data, $this->_arrayInsertDB('dimensoes_cartonagem'));
        $data = array_merge($data, $this->_arrayInsertDB('dimensoes_cartonagem_txt'));
        $data = array_merge($data, $this->_arrayInsertDB('braille'));
        $data = array_merge($data, $this->_arrayInsertDB('qualidade_colagem'));
        $data = array_merge($data, $this->_arrayInsertDB('funcionamento_cartonagem'));
        $data = array_merge($data, $this->_arrayInsertDB('friccao'));
        $data = array_merge($data, $this->_arrayInsertDB('condicoes_acondicionamento'));
        $data = array_merge($data, $this->_arrayInsertDB('informacao_rotulo'));
        $data = array_merge($data, $this->_arrayInsertDB('aprovado'));
        $data = array_merge($data, $this->_arrayInsertDB('data'));
        $data = array_merge($data, $this->_arrayInsertDB('aprovado_por'));
        $data = array_merge($data, $this->_arrayInsertDB('obs'));
        $data = array_merge($data, $this->_arrayInsertDB('password'));
        $data = array_merge($data, $this->_arrayInsertDB('embalagens_inspeccionadas'));
        $data = array_merge($data, $this->_arrayInsertDB('defeitos_maiores'));
        $data = array_merge($data, $this->_arrayInsertDB('defeitos_menores'));
        $data = array_merge($data, array('datetime' => date('Y-m-d G:H:i')));
        
        
        return $data;
    }
}
























?>