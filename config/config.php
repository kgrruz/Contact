<?php defined('BASEPATH') || exit('No direct script access allowed');

$config['module_config'] = array(
	'description'	=> 'Manage contacts',
	'category'    => 'CRM',
	'name'		    => 'Contact',
	'home'				=> 'contacts',
	'label'       => array('english'=>'contacts','portuguese_br'=>'contatos'),
	'route'       => 'contact',
	'visible_module' => true,
	'version'		=> '1.3.0',
	'author'		=> 'admin',
	'tab_contact'=>array(
		'label'=> array('english'=>'Employees','portuguese_br'=>'Funcionários'),
		'url'=>'company_contacts',
		'contact_type'=>array(2)
	)
);

$config['install_check'] = array(
'php_version'=>array('5.6','>='),
'gestor_version'=>array('0.4.0-dev','>='),
'php_ext'=>array('mbstring'),
'modules'=>array());

$config['load_gravatar'] = false;
