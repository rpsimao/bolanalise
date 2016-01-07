<?php

class Bootstrap extends Zend_Application_Bootstrap_Bootstrap
{

    protected function _initRegistry ()
    {
   
            Zend_Registry::set('passwords', new Zend_Config_Ini(APPLICATION_PATH . '/configs/application.ini', 'passwords'));
            Zend_Registry::set('optimus', new Zend_Config_Ini(APPLICATION_PATH . '/configs/application.ini', 'optimus'));
        
        if (APPLICATION_ENV == "development") 
        {
             Zend_Registry::set('boletins', new Zend_Config_Ini(APPLICATION_PATH . '/configs/application.ini', 'boletins_teste'));
             
        } else {
             
            Zend_Registry::set('boletins', new Zend_Config_Ini(APPLICATION_PATH . '/configs/application.ini', 'boletins'));
        }
       
        Zend_Registry::set('embalagem', new Zend_Config_Ini(APPLICATION_PATH . '/configs/application.ini', 'embalagem'));
        Zend_Registry::set('mail_server', new Zend_Config_Ini(APPLICATION_PATH . '/configs/application.ini', 'mail_server'));
    }
    
    
    protected function _initHeader ()
    {
    
        $this->bootstrap('layout');
        $layout = $this->getResource('layout');
        $view = $layout->getView();
        $view->addHelperPath("RPS/Views/Helper", "RPS_Views_Helper");
        $view->doctype("HTML5");
        $view->headTitle('Fernandes & Terceiro, S.A. :: Boletim Análise');
        $view->headMeta()->setCharset('utf-8');
        $view->headScript()->appendFile('/assets/library/external/html5.js','text/javascript', array('conditional' => 'lt IE 9'));
        $view->headScript()->appendFile('/assets/library/external/IE7.js','text/javascript', array('conditional' => 'lt IE 7'));
        $view->headScript()->appendFile('/assets/library/external/IE8.js','text/javascript', array('conditional' => 'lt IE 8'));
        $view->headScript()->appendFile('/assets/library/external/IE9.js','text/javascript', array('conditional' => 'lt IE 9'));
        $view->headScript()->appendFile('/assets/library/js/jquery/latest/min.js', 'text/javascript');
        $view->headScript()->appendFile('/assets/library/js/jqueryui/bootstrap/jquery-ui-1.9.2.custom.min.js', 'text/javascript');
        $view->headScript()->appendFile('/assets/library/plugins/qtip2/jquery.qtip.min.js', 'text/javascript');
        $view->headScript()->appendFile('/js/app.bootstrap.js', 'text/javascript');
        $view->headLink()->appendStylesheet('/assets/library/js/jqueryui/themes/bootstrap/jquery-ui-1.9.2.custom.css');
        $view->headScript()->appendFile('/assets/library/bootstrap/js/bootstrap.min.js','text/javascript');
        $view->headScript()->appendFile('/assets/library/bootstrap/js/bootstrap-notify.js','text/javascript');
        $view->headLink()->appendStylesheet('/assets/library/bootstrap/css/bootstrap.min.css');
        $view->headLink()->appendStylesheet('/assets/library/bootstrap/css/font-awesome.min.css');
        $view->headLink()->appendStylesheet('/assets/library/bootstrap/css/bootstrap-responsive.min.css');
        $view->headLink()->appendStylesheet('/assets/library/bootstrap/css/bootstrap-notify.css');
        $view->headLink()->appendStylesheet('/assets/library/bootstrap/css/alert-notification-animations.css');
        $view->headLink()->appendStylesheet('/assets/library/bootstrap/css/alert-blackgloss.css');
        $view->headLink()->appendStylesheet('/assets/library/plugins/qtip2/jquery.qtip.min.css');
        $view->headLink()->appendStylesheet('/css/styles.css');
        //$view->headLink()->headLink(array('rel' => 'icon' ,'href' => 'http://static.fterceiro.pt/assets/public/images/favicon.ico', 'type'=>"image/x-icon"), 'PREPEND');
        $view->headMeta()->appendHttpEquiv('X-UA-Compatible', 'chrome=1');
        $view->headMeta()->appendName('Author', 'Ricardo Simao');
        $view->headMeta()->appendName('Email', 'ricardo.simao@fterceiro.pt');
        $view->headMeta()->appendName('Copyright', 'Fernandes e Terceiro, S.A.');
        $view->headMeta()->appendName('Zend Framework', Zend_Version::VERSION);
        $view->headMeta()->appendName('PHP',  phpversion());
        $view->headMeta()->appendName('Version', '@@BuildNumber@@');
        $view->headMeta()->appendName('BuildDate', '@@BuildDate@@');
    }
    
    protected function _initValidateTranslation()
    {
       $translator = new Zend_Translate(
          array(
                'adapter' => 'array',
                'content' => APPLICATION_PATH . '/languages/resources/',
                'locale'  => new Zend_Locale('pt_PT'),
                'scan'    => Zend_Translate::LOCALE_DIRECTORY)
        );
        Zend_Validate_Abstract::setDefaultTranslator($translator);
    }
    
    protected function _initRoutes() 
    {
       $router = Zend_Controller_Front::getInstance()->getRouter();
       
       $route = new Zend_Controller_Router_Route('search/:num', array(
                    'controller' => 'search' , 
                    'action' => 'index'));
        $router->addRoute('search_index', $route);
        
        $route = new Zend_Controller_Router_Route('searchdate/:date', array(
                    'controller' => 'searchdate' ,
                    'action' => 'index'));
        $router->addRoute('searchdate_index', $route);
        
        $route = new Zend_Controller_Router_Route('boletim/renderpdf/:id', array(
                    'controller' => 'boletim' ,
                    'action' => 'renderpdf'));
        $router->addRoute('boletim_renderpdf', $route);
        
        $route = new Zend_Controller_Router_Route('searchoc/bp/:oc', array(
                    'controller' => 'searchoc' ,
                    'action' => 'bp'));
        $router->addRoute('searchoc_bpf', $route);
        
        $route = new Zend_Controller_Router_Route('searchoc/zimbra/:oc', array(
                    'controller' => 'searchoc' ,
                    'action' => 'zimbra'));
        $router->addRoute('searchoc_zimbra', $route);
        
        $route = new Zend_Controller_Router_Route('download/pdf/:id', array(
                    'controller' => 'download' ,
                    'action' => 'pdf'));
        $router->addRoute('index_download', $route);
    }
}

