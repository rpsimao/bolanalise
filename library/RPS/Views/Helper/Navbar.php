<?php
class RPS_Views_Helper_Navbar extends Zend_View_Helper_Abstract
{

    protected $html;
    protected $formdate;
    protected $formoc;
    protected $formobra;
	protected $dropdown;
    public function Navbar ()
    {
        
        $this->formoc   = new Application_Form_Searchoc();
        $this->formobra = new Application_Form_Searchobra();
        $badges = $this->_badges();


		$this->dropdown = '<li class="dropdown">
                      <a href="#" id="drop2" role="button" class="dropdown-toggle" data-toggle="dropdown">Emails<b class="caret"></b></a>
                      <ul class="dropdown-menu" role="menu" aria-labelledby="drop2">
                        <li role="presentation"><a role="menuitem" tabindex="-1" href="/emails">Definir Emails</a></li>
					  </ul>
                    </li>';

        $this->html = '<div class="navbar navbar-inverse navbar-fixed-top">
		<div class="navbar-inner"> 
			<div class="container-fluid">
				<a class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse"> <span class="icon-bar"></span> <span class="icon-bar"></span> <span class="icon-bar"></span></a> 
                 <span class="brand">Boletim Análise</span>
				<div class="nav-collapse collapse">
					<ul class="nav" id="first-nav">
						<li '.$this->_defineActive('index', 'index').'><a href="/"><i class="icon-home icon-white"></i> Home </a></li>
                        <li '.$this->_defineActive('searchdate', 'today').'><a href="/searchdate/'.$this->_defineday('today').'"><i class="icon-table icon-white"></i> Hoje <span class="badge badge-info">'.$badges['today'].'</span></a></li>
                        <li '.$this->_defineActive('searchdate', 'yesterday').'><a href="/searchdate/'.$this->_defineday('yesterday').'"><i class="icon-table icon-white"></i> Ontem <span class="badge badge-info">'.$badges['yesterday'].'</span></a></li>
                        <li '.$this->_defineActive('search', 'semana').'><a href="/searchdate/semana"><i class="icon-table icon-white"></i> Semana <span class="badge badge-info">'.$badges['semana'].'</span></a></li>
                        <li '.$this->_defineActive('search', 'mes').'><a href="/search/mes/index"><i class="icon-table icon-white"></i> Mês <span class="badge badge-info">'.$badges['mes'].'</span></a></li>
                        <li '.$this->_defineActive('search', 'ano').'><a href="/search/ano/index"><i class="icon-table icon-white"></i> Ano <span class="badge badge-info">'.$badges['ano'].'</span></a></li>
                        <li '.$this->_defineActive('emails', 'index').'><a href="/emails"><i class="icon-envelope icon-white"></i> Emails </a></li></li>
                     </ul>
                     <ul class="nav pull-right">
                        <li><a href="#" onclick="showOpcoes()"><i class="icon-search icon-white"></i><span id="opcoesProcuraNavBar">Mostrar Opções</span></a></li>        
                      </ul>        
                      <ul class="nav pull-right" style="display:none;" id="showOpcoesNavBar"><li><div class="input-prepend top-5 right-5"><form enctype="application/x-www-form-urlencoded" action="/searchdate" method="post"><span class="add-on"><i class="icon-calendar"></i></span><input type="text" name="navbardateform" id="navbardateform" value="" class="span2" placeholder="Procurar por data" onchange="triggerdate()" /></form> </div></li><li><div class="input-prepend top-5 right-5"><form enctype="application/x-www-form-urlencoded" action="/search" method="post"><span class="add-on"><i class="icon-file"></i></span><input type="text" name="jnumber" id="jnumber" value="" class="span2" placeholder="Procurar por obra"></form></div></li><li><div class="input-prepend top-5 right-5"><form enctype="application/x-www-form-urlencoded" action="/searchoc" method="post"><span class="add-on"><i class="icon-file-alt"></i></span><input type="text" name="navbarocform" id="navbarocform" value="" class="span2" placeholder="Procurar por O.C."></form> </div></li>  <li id="fly-home"></li></ul></div></div></div></div>';
        return $this->html;
    }

    /**
     * @param $day
     * @return string
     */

    private function _defineday($day)
    {
        switch ($day) {
            case 'today':
                 return Zend_Date::now()->toString('YYYY-MM-dd');
            break;
            
            case 'yesterday':
                 return Zend_Date::now()->subDay(1)->toString('YYYY-MM-dd');
            break;
        }
        
    }

    /**
     * @return array
     */

    private function _badges()
    {
        $db        = new Application_Model_Boletins();
        $today     = count($db->searchByDate($this->_defineday('today')));
        $yestarday = count($db->searchByDate($this->_defineday('yesterday')));
        $semana    = count($db->getSemana());
        $mes       = count($db->getMes());
        $ano       = count($db->getYear());
        
        return array('today' => $today, 'yesterday' => $yestarday, 'semana' => $semana, 'mes' => $mes, 'ano' => $ano);
        
        
    }

    /**
     * @param $ct
     * @param $at
     * @return string
     */

    private function _defineActive($ct, $at)
    {
        $request    = Zend_Controller_Front::getInstance()->getRequest();

        $controller = $request->getControllerName();
        $action     = $request->getActionName();
        $param      = $request->getParam("date");



        if ($controller == $ct && $at == $action)
        {
            return 'class="active"';
        }

        if ($controller == $ct && $at == "today" && $param == Zend_Date::now()->toString('YYYY-MM-dd'))
            {
                return 'class="active"';
            }

        if ($controller == $ct && $at == "yesterday" && $param == Zend_Date::now()->subDay(1)->toString('YYYY-MM-dd') )
        {
            return 'class="active"';
        }






    }
}
?>