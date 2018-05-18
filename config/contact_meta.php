<?php defined('BASEPATH') || exit('No direct script access allowed');
/**
 * Erplib
 *
 * An open source project to allow developers to jumpstart their development of
 * CodeIgniter applications.
 *
 * @package   Erplib
 * @author    Erplib Dev Team
 * @copyright Copyright (c) 2016 - 2017, Erplib Dev Team
 * @license   http://opensource.org/licenses/MIT
 * @since     Version 1.0
 * @filesource
 */

//------------------------------------------------------------------------------
// User Meta Fields Config - These are just examples of various options
// The following examples show how to use regular inputs, select boxes,
// state and country select boxes.
//------------------------------------------------------------------------------

$config['person_meta_fields'] =  array(
	array(
		'name'   => 'adress',
    'label'  => 'adress',
    'rules'  => 'trim'
	),
	array(
		'name'   => 'country',
		'label'   => lang('user_meta_country'),
		'rules'   => 'trim|max_length[100]',
        'admin_only'    => false,
		'form_detail' => array(
			'type' => 'country_select',
			'settings' => array(
				'name'		=> 'country',
				'id'		=> 'country',
				'maxlength'	=> '100',
				'class'		=> 'form-control form-control-sm'
	))),
	array(
		'name'   => 'state',
		'label'   => lang('user_meta_state'),
        'rules'         => 'trim|max_length[100]',
		'form_detail' => array(
			'type' => 'state_select',
			'settings' => array(
				'name'		=> 'state',
				'id'		=> 'state',
                'maxlength' => '3',
				'class'		=> 'span1'
	))),
	array(
		'name'   => 'city',
    'label'  => 'city',
    'rules'  => 'trim'
	),

	array(
		'name'   => 'neibor',
		'label'  => 'neibor',
		'rules'  => 'trim'
	),

	array(
		'name'   => 'num_adress',
    'label'  => 'num_adress',
    'rules'  => 'trim'
	),
	array(
		'name'   => 'lat',
		'label'  => 'lat',
		'rules'  => 'trim'
	),
	array(
		'name'   => 'lng',
		'label'  => 'lng',
		'rules'  => 'trim'
	)
);


$config['company_meta_fields'] =  array(

	array(
		'name'   => 'cnpj',
    'label'  => 'cnpj',
    'rules'  => 'trim'
	),
	array(
		'name'   => 'size',
    'label'  => 'size',
    'rules'  => 'trim'
	),
	array(
		'name'   => 'adress',
    'label'  => 'adress',
    'rules'  => 'trim'
	),
	array(
		'name'   => 'country',
		'label'   => lang('user_meta_country'),
		'rules'   => 'trim|max_length[100]',
        'admin_only'    => false,
		'form_detail' => array(
			'type' => 'country_select',
			'settings' => array(
				'name'		=> 'country',
				'id'		=> 'country',
				'maxlength'	=> '100',
				'class'		=> 'form-control form-control-sm'
	))),
	array(
		'name'   => 'state',
		'label'   => lang('user_meta_state'),
        'rules'         => 'trim|max_length[3]',
		'form_detail' => array(
			'type' => 'state_select',
			'settings' => array(
				'name'		=> 'state',
				'id'		=> 'state',
                'maxlength' => '3',
				'class'		=> 'form-control form-control-sm'
	))),
	array(
		'name'   => 'city',
    'label'  => 'city',
    'rules'  => 'trim'
	),
	array(
		'name'   => 'neibor',
		'label'  => 'neibor',
		'rules'  => 'trim'
	),
	array(
		'name'   => 'num_adress',
    'label'  => 'num_adress',
    'rules'  => 'trim'
	),
	array(
		'name'   => 'lat',
		'label'  => 'lat',
		'rules'  => 'trim'
	),
	array(
		'name'   => 'lng',
		'label'  => 'lng',
		'rules'  => 'trim'
	)
);
