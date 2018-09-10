<?php defined('BASEPATH') || exit('No direct script access allowed');

class Migration_Install_group_contact extends Migration
{
	/**
	 * @var string The name of the database table
	 */
	private $table_name = 'contacts_groups';

	/**
	 * @var array The table's fields
	 */
	private $fields = array(
		'id_join_group' => array(
			'type'       => 'BIGINT',
			'constraint' => 20,
			'auto_increment' => true,
		),
        'id_contact_join' => array(
            'type'       => 'BIGINT',
            'constraint' => 20,
            'null'       => false,
        ),
        'id_group_join' => array(
            'type'       => 'BIGINT',
            'constraint' => 20,
            'null'       => false,
        ),
    	'created_on' => array(
            'type'       => 'datetime',
            'default'    => date('Y-m-d H:i:s'),
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
		$this->dbforge->add_key('id_join_group', true);
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
