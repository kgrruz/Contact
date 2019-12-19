<?php defined('BASEPATH') || exit('No direct script access allowed');

class Migration_Install_contact extends Migration
{
	/**
	 * @var string The name of the database table
	 */
	private $table_name = 'contacts';
	private $table_name_contacts_users = 'contacts_users';

	/**
	 * @var array The table's fields
	 */
	private $fields = array(
		'id_contact' => array(
			'type'       => 'INT',
			'constraint' => 11,
			'auto_increment' => true,
		),
        'display_name' => array(
            'type'       => 'VARCHAR',
            'constraint' => 255,
            'null'       => false,
        ),
           'slug_contact' => array(
            'type'       => 'VARCHAR',
            'constraint' => 255,
            'null'       => false,
        ),
        'email' => array(
            'type'       => 'VARCHAR',
            'constraint' => 255,
            'null'       => true,
        ),
        'phone' => array(
            'type'       => 'VARCHAR',
            'constraint' => 30,
            'null'       => true
        ),
        'contact_type' => array(
            'type'       => 'TINYINT',
            'constraint' => 1,
						'default'		 => 1,
            'null'       => false
        ),
        'timezone' => array(
            'type'       => 'VARCHAR',
            'constraint' => 10,
            'null'       => true,
        ),
        'deleted' => array(
            'type'       => 'TINYINT',
            'constraint' => 1,
            'default'    => '0',
        ),
        'deleted_by' => array(
            'type'       => 'BIGINT',
            'constraint' => 20,
            'null'       => true,
        ),
        'created_on' => array(
            'type'       => 'datetime',
            'default'    => '0000-00-00 00:00:00',
        ),
        'created_by' => array(
            'type'       => 'BIGINT',
            'constraint' => 20,
            'null'       => false,
        ),
        'modified_on' => array(
            'type'       => 'datetime',
            'default'    => '0000-00-00 00:00:00',
        ),
        'modified_by' => array(
            'type'       => 'BIGINT',
            'constraint' => 20,
            'null'       => true,
        )
	);
	private $fields_contacts_users = array(
		'id_access_key' => array(
			'type'       => 'INT',
			'constraint' => 11,
			'auto_increment' => true,
		),
        'contact_id' => array(
            'type'       => 'INT',
            'constraint' => 11,
            'null'       => false,
        ),
           'user_id' => array(
            'type'       => 'INT',
            'constraint' => 11,
            'null'       => false,
        ),
        'created_on' => array(
            'type'       => 'datetime',
            'default'    => '0000-00-00 00:00:00',
        ));

	/**
	 * Install this version
	 *
	 * @return void
	 */
	public function up()
	{
		if ( ! $this->db->table_exists($this->table_name)){

		$this->dbforge->add_field($this->fields);
		$this->dbforge->add_key('id_contact', true);
		$this->dbforge->create_table($this->table_name);

	}
		if ( ! $this->db->table_exists($this->table_name_contacts_users)){

		$this->dbforge->add_field($this->fields_contacts_users);
		$this->dbforge->add_key('id_access_key', true);
		$this->dbforge->create_table($this->table_name_contacts_users);

	}

		//insert widget

		$data_widget = array(
			'name_widget'=>'Add contact',
			'description_widget'=>'Display add contact button',
			'order_view'=>0,
			'panel'=>'available',
			'path'=>serialize(array("class"=>"Events_contact","function"=>"_show_widget_button")),
			'module'=>'contact'
		);

		$this->db->insert("widgets",$data_widget);

		$data_widget2 = array(
			'name_widget'=>'My contacts',
			'description_widget'=>'Display list of my related contacts',
			'order_view'=>0,
			'panel'=>'available',
			'path'=>serialize(array("class"=>"Events_contact","function"=>"_user_contacts")),
			'module'=>'contact'
		);

		$this->db->insert("widgets",$data_widget2);

		$version = Modules::config("contact");

		$data_st = array(
			'name' => 'contact.module_update',
			'module' => 'contact',
			'value' => serialize(array("timestamp"=>time(),"version"=>$version['version'],"update"=>0))
		);

		$this->db->insert("settings",$data_st);

		if(!empty($this->input->post('country'))){

		 $country = $this->input->post('country'); 

		}else{ 

			$country = settings_item('auth.default_country'); 

		}

		$data_st0 = array(
			'name' => 'contact.default_timezone',
			'module' => 'contact',
			'value' => settings_item('site.default_user_timezone')
		);

		$this->db->insert("settings",$data_st0);

		$data_st1 = array(
			'name' => 'contact.default_country',
			'module' => 'contact',
			'value' => $country
		);

		$this->db->insert("settings",$data_st1);

		$data_st1A = array(
			'name' => 'contact.default_state',
			'module' => 'contact',
			'value' => ""
		);

		$this->db->insert("settings",$data_st1A);

		$data_st2 = array(
			'name' => 'contact.allow_user_invite',
			'module' => 'contact',
			'value' => 1
		);

		$this->db->insert("settings",$data_st2);

		$data_st3 = array(
			'name' => 'contact.display_timezone_select',
			'module' => 'contact',
			'value' => 1
		);

		$this->db->insert("settings",$data_st3);

		$data_st4 = array(
			'name' => 'contact.display_country_select',
			'module' => 'contact',
			'value' => 1
		);

		$this->db->insert("settings",$data_st4);

		$data_st5 = array(
			'name' => 'contact.display_state_select',
			'module' => 'contact',
			'value' => 1
		);

		$this->db->insert("settings",$data_st5);

	}

	/**
	 * Uninstall this version
	 *
	 * @return void
	 */
	public function down()
	{
		$this->dbforge->drop_table($this->table_name);
	}
}
