<?php defined('BASEPATH') || exit('No direct script access allowed');

class Migration_Install_contact_permissions extends Migration
{
	/**
	 * @var array Permissions to Migrate
	 */
	private $permissionValues = array(
		array(
			'name' => 'Contact.Content.View',
			'description' => 'View Contact Content',
			'status' => 'active',
		),
		array(
			'name' => 'Contact.Content.Create',
			'description' => 'Create Contact Content',
			'status' => 'active',
		),
		array(
			'name' => 'Contact.Content.Edit',
			'description' => 'Edit Contact Content',
			'status' => 'active',
		),
		array(
			'name' => 'Contact.Content.Delete',
			'description' => 'Delete Contact Content',
			'status' => 'active',
		),
		array(
			'name' => 'Contact.Reports.View',
			'description' => 'View Contact Reports',
			'status' => 'active',
		),
		array(
			'name' => 'Contact.Reports.Create',
			'description' => 'Create Contact Reports',
			'status' => 'active',
		),
		array(
			'name' => 'Contact.Reports.Edit',
			'description' => 'Edit Contact Reports',
			'status' => 'active',
		),
		array(
			'name' => 'Contact.Reports.Delete',
			'description' => 'Delete Contact Reports',
			'status' => 'active',
		),
		array(
			'name' => 'Contact.Settings.View',
			'description' => 'View Contact Settings',
			'status' => 'active',
		),
		array(
			'name' => 'Contact.Settings.Create',
			'description' => 'Create Contact Settings',
			'status' => 'active',
		),
		array(
			'name' => 'Contact.Settings.Edit',
			'description' => 'Edit Contact Settings',
			'status' => 'active',
		),
		array(
			'name' => 'Contact.Settings.Delete',
			'description' => 'Delete Contact Settings',
			'status' => 'active',
		),
		array(
			'name' => 'Contact.Developer.View',
			'description' => 'View Contact Developer',
			'status' => 'active',
		),
		array(
			'name' => 'Contact.Developer.Create',
			'description' => 'Create Contact Developer',
			'status' => 'active',
		),
		array(
			'name' => 'Contact.Developer.Edit',
			'description' => 'Edit Contact Developer',
			'status' => 'active',
		),
		array(
			'name' => 'Contact.Developer.Delete',
			'description' => 'Delete Contact Developer',
			'status' => 'active',
		),
    );

    /**
     * @var string The name of the permission key in the role_permissions table
     */
    private $permissionKey = 'permission_id';

    /**
     * @var string The name of the permission name field in the permissions table
     */
    private $permissionNameField = 'name';

	/**
	 * @var string The name of the role/permissions ref table
	 */
	private $rolePermissionsTable = 'role_permissions';

    /**
     * @var numeric The role id to which the permissions will be applied
     */
    private $roleId = '1';

    /**
     * @var string The name of the role key in the role_permissions table
     */
    private $roleKey = 'role_id';

	/**
	 * @var string The name of the permissions table
	 */
	private $tableName = 'permissions';

	//--------------------------------------------------------------------

	/**
	 * Install this version
	 *
	 * @return void
	 */
	public function up()
	{
		$rolePermissionsData = array();
		foreach ($this->permissionValues as $permissionValue) {
			$this->db->insert($this->tableName, $permissionValue);

			$rolePermissionsData[] = array(
                $this->roleKey       => $this->roleId,
                $this->permissionKey => $this->db->insert_id(),
			);
		}

		$this->db->insert_batch($this->rolePermissionsTable, $rolePermissionsData);
	}

	/**
	 * Uninstall this version
	 *
	 * @return void
	 */
	public function down()
	{
        $permissionNames = array();
		foreach ($this->permissionValues as $permissionValue) {
            $permissionNames[] = $permissionValue[$this->permissionNameField];
        }

        $query = $this->db->select($this->permissionKey)
                          ->where_in($this->permissionNameField, $permissionNames)
                          ->get($this->tableName);

        if ( ! $query->num_rows()) {
            return;
        }

        $permissionIds = array();
        foreach ($query->result() as $row) {
            $permissionIds[] = $row->{$this->permissionKey};
        }

        $this->db->where_in($this->permissionKey, $permissionIds)
                 ->delete($this->rolePermissionsTable);

        $this->db->where_in($this->permissionNameField, $permissionNames)
                 ->delete($this->tableName);
	}
}