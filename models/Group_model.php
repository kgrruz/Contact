<?php defined('BASEPATH') || exit('No direct script access allowed');

class Group_model extends BF_Model{

  protected $table_name	= 'groups';
	protected $key			  = 'id_group';
	protected $date_format	= 'datetime';

	protected $log_user 	= true;
	protected $set_created	= true;
	protected $set_modified = true;
	protected $soft_deletes	= true;

	protected $created_field     = 'created_on';
  protected $created_by_field  = 'created_by';
	protected $modified_field    = 'modified_on';
  protected $modified_by_field = 'modified_by';
  protected $deleted_field     = 'deleted';
  protected $deleted_by_field  = 'deleted_by';

	// Customize the operations of the model without recreating the insert,
    // update, etc. methods by adding the method names to act as callbacks here.
	protected $before_insert 	= array();
	protected $after_insert 	= array();
	protected $before_update 	= array();
	protected $after_update 	= array();
	protected $before_find 	    = array();
	protected $after_find 		= array();
	protected $before_delete 	= array();
	protected $after_delete 	= array();

	// For performance reasons, you may require your model to NOT return the id
	// of the last inserted row as it is a bit of a slow method. This is
    // primarily helpful when running big loops over data.
	protected $return_insert_id = true;

	// The default type for returned row data.
	protected $return_type = 'object';

	// Items that are always removed from data prior to inserts or updates.
	protected $protected_attributes = array();

	// You may need to move certain rules (like required) into the
	// $insert_validation_rules array and out of the standard validation array.
	// That way it is only required during inserts, not updates which may only
	// be updating a portion of the data.
	protected $validation_rules 		= array(
		array(
			'field' => 'group_name',
			'label' => 'lang:group_field_group_name',
			'rules' => 'required|trim|max_length[255]',
		),
		array(
			'field' => 'description',
			'label' => 'lang:group_field_description',
			'rules' => 'trim|max_length[500]',
		)
	);
	protected $insert_validation_rules  = array();
	protected $skip_validation 			= false;

  /**
   * Constructor
   *
   * @return void
   */
  public function __construct(){

      parent::__construct();
  }

  public function search_groups_json($term){

    $like = array('group_name' => $term);
    $this->db->select("id_group,group_name,description");
    $this->db->from('groups');
    $this->db->where('deleted', 0);
    $this->db->like($like);
    $this->db->limit(5);
    $query = $this->db->get()->result();

    return $query;

  }

  function get_contact_groups($id){

    $this->db->select('id_group,group_name');
    $this->db->from('contacts_groups');
    $this->db->join('groups','groups.id_group  = contacts_groups.id_group_join');
    $this->db->where('id_contact_join',$id);
    return $this->db->get()->result();


  }

  function get_contact_groups_array($id){

    $data = $this->get_contact_groups($id);
    $ids  = array();

    foreach($data as $group){

      array_push($ids,$group->id_group);

    }

    return $ids;

  }

  function get_contacts_in_group($id){

    $this->db->select('id_contact,slug_contact,phone,modified_on,display_name,email,contacts_groups.created_on');
    $this->db->from('contacts_groups');
    $this->db->join('contacts','contacts.id_contact  = contacts_groups.id_contact_join');
    $this->db->where('id_group_join',$id);
    return $this->db->get()->result();


  }

  public function count_contacts_in_group($id){

    $this->db->select('id_join_group');
    $this->db->from('contacts_groups');
    $this->db->where('id_group_join',$id);
    return $this->db->get()->num_rows();

  }


  function get_groups_tree(){


  }

}
