<?php
if(!defined('_PS_VERSION_'))
exit;

class custom_module extends Module{
    public function __construct()
    {
        $this->name = 'custom_module'; //nombre del módulo el mismo que la carpeta y la clase.
        $this->tab = 'front_office_features'; // pestaña en la que se encuentra en el backoffice.
        $this->version = '1.0.0'; //versión del módulo
        $this->author ='Marta Romeu'; // autor del módulo
        $this->need_instance = 0; //si no necesita cargar la clase en la página módulos,1 si fuese necesario.
        $this->ps_versions_compliancy = array('min' => '1.7.x.x', 'max' => _PS_VERSION_); //las versiones con las que el módulo es compatible.
        $this->bootstrap = true; //si usa bootstrap plantilla responsive.

        parent::__construct(); //llamada al constructor padre.

        $this->displayName = $this->l('Custom module'); // Nombre del módulo
        $this->description = $this->l('Módulo de prueba.'); //Descripción del módulo
        $this->confirmUninstall = $this->l('¿Estás seguro de que quieres desinstalar el módulo?'); //mensaje de alerta al desinstalar el módulo.

        $this->templateFile = 'module:custom_module/views/templates/hook/custom_module.tpl';
    }

    
    public function hookDisplayHeader($params)
    {		
	  	$this->context->controller->registerStylesheet('modules-custom_module', 'modules/'.$this->name.'/views/css/customModule.css', ['media' => 'all', 'priority' => 150]);
        $this->context->controller->registerJavascript('modules-custom_module_js', 'modules/'.$this->name.'/views/js/customModule.js',[ 'position' => 'bottom','priority' => 150]);
    }
	
	public function install()
    {
        return (parent::install()
        && $this->registerHook('displayHeader') // Registramos el hook dentro de las cabeceras.
        && $this->registerHook('displayCarrierExtraContent')
        );

        $this->emptyTemplatesCache();

        return (bool) $return;
    }


    public function uninstall()
    {
    $this->_clearCache('*');

    if(!parent::uninstall() || !$this->unregisterHook('displayHome'))
        return false;

    return true;
    }
    public function hookDisplayHome(){
        return $this->display(__FILE__, 'views/templates/hook/custom_module.tpl');
    }
 }

?>