<?php defined('BASEPATH') || exit('No direct script access allowed');

class Migration_Install_contact_meta extends Migration
{
	/**
	 * @var string The name of the database table
	 */
	private $table_name = 'contact_meta';

	/**
	 * @var array The table's fields
	 */
	private $fields = array(
		'meta_id' => array(
			'type'       => 'INT',
			'constraint' => 20,
			'auto_increment' => true,
		),
        'contact_id' => array(
            'type'       => 'BIGINT',
            'constraint' => 20,
            'null'       => false,
        ),
        'meta_key' => array(
            'type'       => 'VARCHAR',
            'constraint' => 255,
            'null'       => false,
        ),
        'meta_value' => array(
            'type'       => 'TEXT',
            'null'       => true
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
		$this->dbforge->add_key('meta_id', true);
		$this->dbforge->add_key('contact_id');
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
