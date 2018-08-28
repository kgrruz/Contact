<?php defined('BASEPATH') || exit('No direct script access allowed');

class Migration_Install_groups extends Migration
{
	/**
	 * @var string The name of the database table
	 */
	private $table_name = 'groups';

	/**
	 * @var array The table's fields
	 */
	private $fields = array(
		'id_group' => array(
			'type'       => 'INT',
			'constraint' => 20,
			'auto_increment' => true,
		),
        'group_name' => array(
            'type'       => 'VARCHAR',
            'constraint' => 255,
            'null'       => false,
        ),
        'slug_group' => array(
            'type'       => 'VARCHAR',
            'constraint' => 255,
            'null'       => false,
        ),
        'parent_group' => array(
            'type'       => 'INT',
            'constraint' => 11,
            'null'       => true,
        ),
        'lft' => array(
            'type'       => 'INT',
            'constraint' => 11,
            'null'       => false,
        ),
        'rgt' => array(
            'type'       => 'INT',
						'constraint' => 11,
            'null'       => false,
        ),
				'description' => array(
						'type'       => 'TEXT',
						'null'       => false,
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
        ));

	/**
	 * Install this version
	 *
	 * @return void
	 */
	public function up()
	{
		$this->dbforge->add_field($this->fields);
		$this->dbforge->add_key('id_group', true);
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
