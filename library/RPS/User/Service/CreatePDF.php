<?php
/** 
 * @author rpsimao
 * 
 */
class RPS_User_Service_CreatePDF
{
    protected $id;
    protected $user;
    
    public function setBolID($id)
    {
        $this->id = $id;
    }
    
    
    private function _getBolID()
    {
        return $this->id;
    }
    
    
    public function setUser($user)
    {
        $this->user = $user;
    }
    
    private function _getUser()
    {
        return $this->user;
    }
    
    
    private function _setPDFBase()
    {
        
        $user = $this->_getUser();
        
        $db = new Application_Model_Passwords();
        $username = $db->getRecords($user);
        
               
        switch ($username['user']) {
             
            case ('carina.santos@fterceiro.pt'):
                $pdf = 'pdfs/Boletim_Digital_Carina.pdf';
                return $pdf;
                break;
        
        
            case ('marta.cabral@fterceiro.pt'):
                $pdf = 'pdfs/Boletim_Digital_Marta.pdf';
                return $pdf;
                break;
                 
        
            default:
                $pdf = 'pdfs/Boletim_Digital_clean.pdf';
                return $pdf;
                break;
        }
        
        
    }
    
    
    
    private function _getValuesFromDB()
    {
        $db = new Application_Model_Boletins();
        $row = $db->getBoletim($this->_getBolID());
        return $row;
    }
    
    
    public function savePDF($bolid)
    {
        $this->setBolID($bolid);
        $values = $this->_getValuesFromDB();
        $realname = $values[0]['aprovado_por'];
        $db = new Application_Model_Passwords();
        $username = $db->getPasswordByRealName($realname);
        $this->setUser($username['new_password']);
        $this->_setPDFBase();
        $pdf = $this->buildPDF();
        $pdf->save('/tmp/' . $bolid . ".pdf");
    }
   
    
    
    public function buildPDF()
    {
        $values = $this->_getValuesFromDB();
        $pdf = Zend_Pdf::load($this->_setPDFBase());
        
        foreach ($pdf->pages as $page){
        
        
            $page->saveGS();
            $page->setStyle(RPS_User_Service_Styles::condensed(10));
            $page->drawText($values[0]['id'], 418, 749);
            $page->restoreGS();
            $page->saveGS();
            $page->setStyle(RPS_User_Service_Styles::condensed(10));
            $page->drawText($values[0]['cliente'], 164, 750, 'UTF-8');
            $page->drawText($values[0]['obra'], 496, 719);
            $page->drawText(RPS_User_Service_Styles::convertMoney($values[0]['quantidade']), 439, 734);
            $page->restoreGS();
            $page->saveGS();
            $page->setStyle(RPS_User_Service_Styles::condensed(10));
            $page->drawText($values[0]['produto'], 161, 734, 'UTF-8');
            $page->restoreGS();
            $page->saveGS();
            $page->setStyle(RPS_User_Service_Styles::condensed(10));
            $page->drawText($values[0]['encomenda'], 189, 704);
            $page->drawText($values[0]['codigo'], 190, 734-15);
            $page->restoreGS();
            $page->saveGS();
            $page->setStyle(RPS_User_Service_Styles::checkMark(12));
            $page->drawText("4", 151, 264);
            $page->restoreGS();
            $page->saveGS();
            $page->setStyle(RPS_User_Service_Styles::condensed(10));
            $page->drawText($values[0]['data'], 280, 266);
            $page->restoreGS();
        
            $i = 665;
        
            //Corpo
        
            if (($values[0]['tipo'] == 1) ||
            !empty($values[0]['tipo_txt']) ||
            ($values[0]['gramagem'] == 1) ||
            !empty($values[0]['gramagem_txt']) ||
            ($values[0]['espessura'] == 1) ||
            !empty($values[0]['espessura_txt']) ||
            ($values[0]['fibra'] == 1)) {
        
                $page->saveGS();
                $page->setStyle(RPS_User_Service_Styles::bold(8));
                $page->drawText("1. Matéria-prima / ", 85, $i, 'UTF-8');
                $page->restoreGS();
                $page->saveGS();
                $page->setStyle(RPS_User_Service_Styles::boldItalic(8));
                $page->drawText("Raw material:", 153, $i, 'UTF-8');
                $page->restoreGS();
                
        
            }
        
        
            if ($values[0]['tipo'] == 1) {
                
                $page->saveGS();
                $page->setStyle(RPS_User_Service_Styles::normal(8));
                $page->drawText("Tipo / ", 100, $i-15);
                $page->restoreGS();
                $page->saveGS();
                $page->setStyle(RPS_User_Service_Styles::normalItalic(8));
                $page->drawText("Type:", 122, $i-15);
                $page->restoreGS();
                $page->saveGS();
                $page->setStyle(RPS_User_Service_Styles::values(9));
                $page->drawText($values[0]['tipo_txt'], 145, $i-15, 'UTF-8');
                $page->restoreGS();
                $page->saveGS();
                $page->setStyle(RPS_User_Service_Styles::checkBox(16));
                $page->drawText("x", 500, $i-15);
                $page->restoreGS();
                $i-=15;
                	
            }
        
            if ($values[0]['gramagem'] == 1) {
                $page->saveGS();
                $page->setStyle(RPS_User_Service_Styles::normal(8));
                $page->drawText("Gramagem / ", 100, $i-15);
                $page->restoreGS();
                $page->saveGS();
                $page->setStyle(RPS_User_Service_Styles::normalItalic(8));
                $page->drawText("Grammage:", 147, $i-15);
                $page->restoreGS();
                $page->saveGS();
                $page->setStyle(RPS_User_Service_Styles::values(9));
                $page->drawText($values[0]['gramagem_txt'] . " g/m2", 193, $i-15, "UTF-8");
                $page->restoreGS();
                $page->saveGS();
                $page->setStyle(RPS_User_Service_Styles::checkBox(16));
                $page->drawText("x", 500, $i-15);
                $page->restoreGS();
                $i-=15;
                	
            }
        
            if ($values[0]['espessura'] == 1) {
                $page->saveGS();
                $page->setStyle(RPS_User_Service_Styles::normal(8));
                $page->drawText("Espessura / ", 100, $i-15);
                $page->restoreGS();
                $page->saveGS();
                $page->setStyle(RPS_User_Service_Styles::normalItalic(8));
                $page->drawText("Thickness:", 145, $i-15);
                $page->restoreGS();
                $page->saveGS();
                $page->setStyle(RPS_User_Service_Styles::values(9));
                $page->drawText($values[0]['espessura_txt'] . " mm", 187, $i-15);
                $page->restoreGS();
                $page->saveGS();
                $page->setStyle(RPS_User_Service_Styles::checkBox(16));
                $page->drawText("x", 500, $i-15);
                $page->restoreGS();
                $i-=15;
                	
            }
        
            if ($values[0]['fibra'] == 1) {
                $page->saveGS();
                $page->setStyle(RPS_User_Service_Styles::normal(8));
                $page->drawText("Fibra / ", 100, $i-15);
                $page->restoreGS();
                $page->saveGS();
                $page->setStyle(RPS_User_Service_Styles::normalItalic(8));
                $page->drawText("Fiber", 124, $i-15);
                $page->restoreGS();
                $page->saveGS();
                $page->setStyle(RPS_User_Service_Styles::checkBox(16));
                $page->drawText("x", 500, $i-15);
                $page->restoreGS();
                $i-=15;
                	
            }
        
        
            if (($values[0]['texto'] == 1) ||
            ($values[0]['cores'] == 1) ||
            !empty($values[0]['cores_txt']) ||
            ($values[0]['verniz'] == 1) ||
            ($values[0]['qualidade_impressao'] == 1) ||
            ($values[0]['codigo_barras'] == 1) ||
            ($values[0]['codigo_laetus'] == 1) ||
            ($values[0]['tinta_reactiva'] == 1) ||
            ($values[0]['codigo_descodificador'] == 1))
        
            {
        
                $page->saveGS();
                $page->setStyle(RPS_User_Service_Styles::bold(8));
                $page->drawText("2. Impressão / ", 85, $i-15, 'UTF-8');
                $page->restoreGS();
                $page->saveGS();
                $page->setStyle(RPS_User_Service_Styles::boldItalic(8));
                $page->drawText("Printing:", 140, $i-15, 'UTF-8');
                $page->restoreGS();
                $i-=15;
        
            }
        
            if ($values[0]['texto'] == 1) {
                $page->saveGS();
                $page->setStyle(RPS_User_Service_Styles::normal(8));
                $page->drawText("Texto (grafismo / padrão aprovado) /", 100, $i-15, 'UTF-8');
                $page->restoreGS();
                $page->saveGS();
                $page->setStyle(RPS_User_Service_Styles::normalItalic(8));
                $page->drawText("Text (graphics / approved standard)", 233, $i-15, 'UTF-8');
                $page->restoreGS();
                $page->saveGS();
                $page->setStyle(RPS_User_Service_Styles::checkBox(16));
                $page->drawText("x", 500, $i-15);
                $page->restoreGS();
                $i-=15;
                	
            }
        
            if ($values[0]['cores'] == 1) {
                $page->saveGS();
                $page->setStyle(RPS_User_Service_Styles::normal(8));
                $page->drawText("Cores (padrão aprovado) / ", 100, $i-15, 'UTF-8');
                $page->restoreGS();
                $page->saveGS();
                $page->setStyle(RPS_User_Service_Styles::normalItalic(8));
                $page->drawText("Colors (approved standard):", 195, $i-15, 'UTF-8');
                $page->restoreGS();
                $page->saveGS();
                $page->setStyle(RPS_User_Service_Styles::values(9));
                $page->drawText($values[0]['cores_txt'], 300, $i-15, 'UTF-8');
                $page->restoreGS();
                $page->saveGS();
                $page->setStyle(RPS_User_Service_Styles::checkBox(16));
                $page->drawText("x", 500, $i-15);
                $page->restoreGS();
                $i-=15;
                	
            }
        
            if ($values[0]['verniz'] == 1) {
                $page->saveGS();
                $page->setStyle(RPS_User_Service_Styles::normal(8));
                $page->drawText("Verniz / ", 100, $i-15);
                $page->restoreGS();
                $page->saveGS();
                $page->setStyle(RPS_User_Service_Styles::normalItalic(8));
                $page->drawText("Varnish", 129, $i-15);
                $page->restoreGS();
                $page->saveGS();
                $page->setStyle(RPS_User_Service_Styles::checkBox(16));
                $page->drawText("x", 500, $i-15);
                $page->restoreGS();
                $i-=15;
                	
            }
        
            if ($values[0]['qualidade_impressao'] == 1) {
                $page->saveGS();
                $page->setStyle(RPS_User_Service_Styles::normal(8));
                $page->drawText("Qualidade de impressão / ", 100, $i-15, 'UTF-8');
                $page->restoreGS();
                $page->saveGS();
                $page->setStyle(RPS_User_Service_Styles::normalItalic(8));
                $page->drawText("Print quality", 193, $i-15, 'UTF-8');
                $page->restoreGS();
                $page->saveGS();
                $page->setStyle(RPS_User_Service_Styles::checkBox(16));
                $page->drawText("x", 500, $i-15);
                $page->restoreGS();
                $i-=15;
                	
            }
        
            if ($values[0]['codigo_barras'] == 1) {
                $page->saveGS();
                $page->setStyle(RPS_User_Service_Styles::normal(8));
                $page->drawText("Leitura do código de barras / ", 100, $i-15, 'UTF-8');
                $page->restoreGS();
                $page->saveGS();
                $page->setStyle(RPS_User_Service_Styles::normalItalic(8));
                $page->drawText("Barcode Readability", 204, $i-15, 'UTF-8');
                $page->restoreGS();
                $page->saveGS();
                $page->setStyle(RPS_User_Service_Styles::checkBox(16));
                $page->drawText("x", 500, $i-15);
                $page->restoreGS();
                $i-=15;
                	
            }
        
        
            if ($values[0]['codigo_laetus'] == 1) {
                $page->saveGS();
                $page->setStyle(RPS_User_Service_Styles::normal(8));
                $page->drawText("Código Laetus / ", 100, $i-15, 'UTF-8');
                $page->restoreGS();
                $page->saveGS();
                $page->setStyle(RPS_User_Service_Styles::normalItalic(8));
                $page->drawText("Laetus Code", 158, $i-15, 'UTF-8');
                $page->restoreGS();
                $page->saveGS();
                $page->setStyle(RPS_User_Service_Styles::checkBox(16));
                $page->drawText("x", 500, $i-15);
                $page->restoreGS();
                $i-=15;
                	
            }
        
        
            if ($values[0]['tinta_reactiva'] == 1) {
                $page->saveGS();
                $page->setStyle(RPS_User_Service_Styles::normal(8));
                $page->drawText("Tinta Reactiva / ", 100, $i-15, 'UTF-8');
                $page->restoreGS();
                $page->saveGS();
                $page->setStyle(RPS_User_Service_Styles::normalItalic(8));
                $page->drawText("Reactive dye", 157, $i-15, 'UTF-8');
                $page->restoreGS();
                $page->saveGS();
                $page->setStyle(RPS_User_Service_Styles::checkBox(16));
                $page->drawText("x", 500, $i-15);
                $page->restoreGS();
                $i-=15;
                	
            }
        
            if ($values[0]['codigo_descodificador'] == 1) {
                $page->saveGS();
                $page->setStyle(RPS_User_Service_Styles::normal(8));
                $page->drawText("Código descodificador / ", 100, $i-15, 'UTF-8');
                $page->restoreGS();
                $page->saveGS();
                $page->setStyle(RPS_User_Service_Styles::normalItalic(8));
                $page->drawText("Code decoder", 185, $i-15, 'UTF-8');
                $page->restoreGS();
                $page->saveGS();
                $page->setStyle(RPS_User_Service_Styles::checkBox(16));
                $page->drawText("x", 500, $i-15);
                $page->restoreGS();
                $i-=15;
                	
            }
        
        
        
        
            if (($values[0]['qualidade_corte_vinco'] == 1) ||
            ($values[0]['dimensoes_cartonagem'] == 1) ||
            !empty($values[0]['dimensoes_cartonagem_txt']) ||
            ($values[0]['braille'] == 1))
            {
        
                $page->saveGS();
                $page->setStyle(RPS_User_Service_Styles::bold(8));
                $page->drawText("3. Corte e Vinco / ", 85, $i-15, 'UTF-8');
                $page->restoreGS();
                $page->saveGS();
                $page->setStyle(RPS_User_Service_Styles::boldItalic(8));
                $page->drawText("Cut and Crease:", 152, $i-15, 'UTF-8');
                $page->restoreGS();
                $i-=15;
        
            }
        
             if ($values[0]['qualidade_corte_vinco'] == 1) {
                $page->saveGS();
                $page->setStyle(RPS_User_Service_Styles::normal(8));
                $page->drawText("Qualidade do corte e vinco (vincos / cortes / picote) / ", 100, $i-15, 'UTF-8');
                $page->restoreGS();
                $page->saveGS();
                $page->setStyle(RPS_User_Service_Styles::normalItalic(8));
                $page->drawText("Quality of cut and crease (crease / cuts / perforation)", 288, $i-15, 'UTF-8');
                $page->restoreGS();
                $page->saveGS();
                $page->setStyle(RPS_User_Service_Styles::checkBox(16));
                $page->drawText("x", 500, $i-15);
                $page->restoreGS();
                $i-=15;
                	
            }
        
             if ($values[0]['dimensoes_cartonagem'] == 1) {
                $page->saveGS();
                $page->setStyle(RPS_User_Service_Styles::normal(8));
                $page->drawText("Dimensões / ", 100, $i-15, 'UTF-8');
                $page->restoreGS();
                $page->saveGS();
                $page->setStyle(RPS_User_Service_Styles::normalItalic(8));
                $page->drawText("Dimensions:", 147, $i-15, 'UTF-8');
                $page->restoreGS();
                $page->saveGS();
                $page->setStyle(RPS_User_Service_Styles::values(9));
                $page->drawText($values[0]['dimensoes_cartonagem_txt'] . " mm", 195, $i-15, 'UTF-8');
                $page->restoreGS();
                $page->saveGS();
                $page->setStyle(RPS_User_Service_Styles::checkBox(16));
                $page->drawText("x", 500, $i-15);
                $page->restoreGS();
                $i-=15;
                	
            }
        
        
            if ($values[0]['braille'] == 1) {
                $page->saveGS();
                $page->setStyle(RPS_User_Service_Styles::normal(8));
                $page->drawText("Braille", 100, $i-15, 'UTF-8');
                $page->restoreGS();
                $page->saveGS();
                $page->setStyle(RPS_User_Service_Styles::checkBox(16));
                $page->drawText("x", 500, $i-15);
                $page->restoreGS();
                $i-=15;;
                	
            }
        
        
        
            if (($values[0]['qualidade_colagem'] == 1) ||
            ($values[0]['funcionamento_cartonagem'] == 1) ||
            ($values[0]['friccao'] == 1))
            {
        
                $page->saveGS();
                $page->setStyle(RPS_User_Service_Styles::bold(8));
                $page->drawText("4. Fecho da Cartonagem / ", 85, $i-15, 'UTF-8');
                $page->restoreGS();
                $page->saveGS();
                $page->setStyle(RPS_User_Service_Styles::boldItalic(8));
                $page->drawText("Carton Closing:", 185, $i-15, 'UTF-8');
                $page->restoreGS();
                $i-=15;
        
            }
        
        
        
            if ($values[0]['qualidade_colagem'] == 1) {
                $page->saveGS();
                $page->setStyle(RPS_User_Service_Styles::normal(8));
                $page->drawText("Colagem / ", 100, $i-15, 'UTF-8');
                $page->restoreGS();
                $page->saveGS();
                $page->setStyle(RPS_User_Service_Styles::normalItalic(8));
                $page->drawText("Collage", 138, $i-15, 'UTF-8');
                $page->restoreGS();
                $page->saveGS();
                $page->setStyle(RPS_User_Service_Styles::checkBox(16));
                $page->drawText("x", 500, $i-15);
                $page->restoreGS();
                $i-=15;
                	
            }
        
             if ($values[0]['funcionamento_cartonagem'] == 1) {
                $page->saveGS();
                $page->setStyle(RPS_User_Service_Styles::normal(8));
                $page->drawText("Funcionamento da Cartonagem / ", 100, $i-15, 'UTF-8');
                $page->restoreGS();
                $page->saveGS();
                $page->setStyle(RPS_User_Service_Styles::normalItalic(8));
                $page->drawText("Carton Operation", 219, $i-15, 'UTF-8');
                $page->restoreGS();
                $page->saveGS();
                $page->setStyle(RPS_User_Service_Styles::checkBox(16));
                $page->drawText("x", 500, $i-15);
                $page->restoreGS();
                $i-=15;
                	
            }
        
        
            if ($values[0]['friccao'] == 1) {
                $page->saveGS();
                $page->setStyle(RPS_User_Service_Styles::normal(8));
                $page->drawText("Teste de Fricção / ", 100, $i-15, 'UTF-8');
                $page->restoreGS();
                $page->saveGS();
                $page->setStyle(RPS_User_Service_Styles::normalItalic(8));
                $page->drawText("Friction test", 166, $i-15, 'UTF-8');
                $page->restoreGS();
                $page->saveGS();
                $page->setStyle(RPS_User_Service_Styles::checkBox(16));
                $page->drawText("x", 500, $i-15);
                $page->restoreGS();
                $i-=15;
                	
            }
        
        
        
            if (($values[0]['condicoes_acondicionamento'] == 1) ||
            ($values[0]['informacao_rotulo'] == 1))
            {
                $page->saveGS();
                $page->setStyle(RPS_User_Service_Styles::bold(8));
                $page->drawText("5. Acondicionamento / ", 85, $i-15, 'UTF-8');
                $page->restoreGS();
                $page->saveGS();
                $page->setStyle(RPS_User_Service_Styles::boldItalic(8));
                $page->drawText("Packaging:", 172, $i-15, 'UTF-8');
                $page->restoreGS();
                $i-=15;
        
            }
        
            if ($values[0]['condicoes_acondicionamento'] == 1) {
                $page->saveGS();
                $page->setStyle(RPS_User_Service_Styles::normal(8));
                $page->drawText("Condições de acondicionamento / ", 100, $i-15, 'UTF-8');
                $page->restoreGS();
                $page->saveGS();
                $page->setStyle(RPS_User_Service_Styles::normalItalic(8));
                $page->drawText("Storage conditions", 222, $i-15, 'UTF-8');
                $page->restoreGS();
                $page->saveGS();
                $page->setStyle(RPS_User_Service_Styles::checkBox(16));
                $page->drawText("x", 500, $i-15);
                $page->restoreGS();
                $i-=15;
                	
            }
        
            if ($values[0]['informacao_rotulo'] == 1) {
                $page->saveGS();
                $page->setStyle(RPS_User_Service_Styles::normal(8));
                $page->drawText("Informação do rótulo / ", 100, $i-15, 'UTF-8');
                $page->restoreGS();
                $page->saveGS();
                $page->setStyle(RPS_User_Service_Styles::normalItalic(8));
                $page->drawText("Label Information", 180, $i-15, 'UTF-8');
                $page->restoreGS();
                $page->saveGS();
                $page->setStyle(RPS_User_Service_Styles::checkBox(16));
                $page->drawText("x", 500, $i-15);
                $page->restoreGS();
                $i-=15;
                	
            }
        
        
            $page->saveGS();
            $page->setStyle(RPS_User_Service_Styles::condensed(8));
            $obs = stripcslashes($values[0]['obs']);
            $obs = wordwrap($obs ,160, '\r\n');
            $headlineArray = explode('\r\n', $obs);
            $startPos = $page->getWidth();
        
            foreach($headlineArray as $line)
            {
        
                $line = ltrim($line, PHP_EOL);
                $page->drawText(ucfirst(mb_strtolower(utf8_decode(str_replace("\r\n", " ", $line)))), 70, $startPos-408, 'ISO-8859-1');
                $startPos = $startPos - 10;
        
            }
        
            $page->restoreGS();
            
            
        }
        
        return $pdf;
        
        
    }
    
    
}    

?>