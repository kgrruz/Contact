<?php defined('BASEPATH') || exit('No direct script access allowed');

$config['module_config'] = array(
	'description'	=> 'Manage contacts',
	'category'    => 'CRM',
	'name'		    => 'Contact',
	'home'				=> 'contacts',
	'label'       => array('en_US'=>'contacts','pt_BR'=>'contatos','es'=>'contactos'),
	'route'       => 'contact',
	'visible_module' => false,
	'version'		=> '1.4.0',
	'author'		=> 'admin',
	'tab_contact'=>array(
		'label'=> array('en_US'=>'Employees','pt_BR'=>'Funcionários'),
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
