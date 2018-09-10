<?php defined('BASEPATH') || exit('No direct script access allowed');

class Migration_Install_contact extends Migration
{
	/**
	 * @var string The name of the database table
	 */
	private $table_name = 'contacts';

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

	/**
	 * Install this version
	 *
	 * @return void
	 */
	public function up()
	{
		$this->dbforge->add_field($this->fields);
		$this->dbforge->add_key('id_contact', true);
		$this->dbforge->create_table($this->table_name);
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
