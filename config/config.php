<?php defined('BASEPATH') || exit('No direct script access allowed');

$config['module_config'] = array(
	'description'	=> 'Manage contacts',
	'category'    => 'CRM',
	'name'		    => 'Contact',
	'home'				=> 'contacts',
	'label'       => array('english'=>'contacts','portuguese_br'=>'contatos'),
	'route'       => 'contact',
	'visible_module' => true,
	'version'		=> '1.1.1',
	'author'		=> 'admin',
	'tab_company'=>array(
		'label'=> array('english'=>'contacts','portuguese_br'=>'contatos'),
		'url'=>'company_contacts'
	)
);
