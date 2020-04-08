<?php defined('BASEPATH') || exit('No direct script access allowed');

class Contact_model extends BF_Model{


	protected $table_name	= 'contacts';
	protected $key			  = 'id_contact';
	protected $date_format	= 'datetime';
	protected $meta_table   = 'contact_meta';

	protected $log_user 	  = true;
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
	protected $before_find 	  = array();
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
			'field' => 'display_name',
			'label' => 'lang:contact_field_display_name',
			'rules' => 'required|trim|max_length[255]',
		),
		array(
			'field' => 'phone',
			'label' => 'lang:contact_field_phone',
			'rules' => 'trim',
		),
		array(
			'field' => 'timezone',
			'label' => 'lang:contact_field_timezone',
			'rules' => 'trim|alpha_numeric|max_length[10]',
		),
		array(
			'field' => 'city',
			'label' => 'lang:contact_field_city',
			'rules' => 'required',
		)
	);
	protected $insert_validation_rules  = array();
	protected $skip_validation 			= false;

    /**
     * Constructor
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }


    function search_general($term,$fields,$limit,$offset){

      $like = array('display_name' => $this->db->escape_str($term));
      $this->db->select($fields);
      $this->db->from('contacts');
      $this->db->where('deleted', 0);
      $this->db->like($like);
      $this->db->limit($limit, $offset);
      $result = $this->db->get()->result();

			foreach($result as $contact){
			$this->where('contact_id', $contact->id_contact);
			$query = $this->db->get($this->meta_table);
			foreach ($query->result() as $row) {
					$key = $row->meta_key;
					$contact->{$key} = $row->meta_value;
			}
		}
			return $result;


    }

		function cities_contacts(){

			$this->db->select("meta_value");
			$this->db->from('contact_meta');
			$this->db->where('meta_key', 'city');
			$this->db->group_by("meta_value");
			$query = $this->db->get();

			return $query;

		}

		function get_job_roles(){

			$this->db->select("meta_value");
			$this->db->from('contact_meta');
			$this->db->where('meta_key', 'job_role');
			$this->db->group_by("meta_value");
			$query = $this->db->get();

			return $query;

		}

    function search_list_json($term){

      $like = array('display_name' => $this->db->escape_str($term));
      $this->db->select("contacts.id_contact as value,contacts.display_name as text");
      $this->db->from('contacts');
      $this->db->where('deleted', 0);
      $this->db->like($like);
      $this->db->limit(5);
      $query = $this->db->get()->result();

      return $query;

    }

    public function get_markersbound($north,$south,$east,$west,$offset){

		 $this->db->cache_on();
     $this->db->select("
         'contact' as module,
				 IF(contact_type = 2, 'bigcity.png', 'male.png') as icon,
				 contacts.id_contact as idc,
				 contacts.display_name as name,
				 MAX(CASE WHEN {$this->db->dbprefix}contact_meta.meta_key = 'city' THEN {$this->db->dbprefix}contact_meta.meta_value END) AS 'city',
				 MAX(CASE WHEN {$this->db->dbprefix}contact_meta.meta_key = 'neibor' THEN {$this->db->dbprefix}contact_meta.meta_value END) AS 'neibor',
				 MAX(CASE WHEN {$this->db->dbprefix}contact_meta.meta_key = 'adress' THEN {$this->db->dbprefix}contact_meta.meta_value END) AS 'adress',
				 MAX(CASE WHEN {$this->db->dbprefix}contact_meta.meta_key = 'num_adress' THEN {$this->db->dbprefix}contact_meta.meta_value END) AS 'num_adress',
				 MAX(CASE WHEN {$this->db->dbprefix}contact_meta.meta_key = 'lat' THEN {$this->db->dbprefix}contact_meta.meta_value END) AS 'lat',
         MAX(CASE WHEN {$this->db->dbprefix}contact_meta.meta_key = 'lng' THEN {$this->db->dbprefix}contact_meta.meta_value END) AS 'lng'
				 ");
				 $this->db->from("contacts");
         $this->db->join("contact_meta","contacts.id_contact = contact_meta.contact_id","left");
         $this->db->group_by("id_contact");
         $this->db->having("cast(lat as DECIMAL(10,3)) <= '{$north}'");
				 $this->db->having("cast(lat as DECIMAL(10,3)) >= '{$south}'");
				 $this->db->having("cast(lng as DECIMAL(10,3)) <= '{$east}'");
				 $this->db->having("cast(lng as DECIMAL(10,3)) >= '{$west}'");
				 $this->db->where("contacts.deleted",0);
				 $this->db->limit(50,$offset);

				 $coordinates = $this->db->get();
				 $this->db->cache_off();
		     return $coordinates->result_array();
    }

    public function count_markersbound($north,$south,$east,$west){

		 $this->db->cache_on();
     $this->db->select("contacts.id_contact as idc,
		 MAX(CASE WHEN {$this->db->dbprefix}contact_meta.meta_key = 'city' THEN {$this->db->dbprefix}contact_meta.meta_value END) AS 'city',
		 MAX(CASE WHEN {$this->db->dbprefix}contact_meta.meta_key = 'neibor' THEN {$this->db->dbprefix}contact_meta.meta_value END) AS 'neibor',
		 MAX(CASE WHEN {$this->db->dbprefix}contact_meta.meta_key = 'adress' THEN {$this->db->dbprefix}contact_meta.meta_value END) AS 'adress',
		 MAX(CASE WHEN {$this->db->dbprefix}contact_meta.meta_key = 'num_adress' THEN {$this->db->dbprefix}contact_meta.meta_value END) AS 'num_adress',
		 MAX(CASE WHEN {$this->db->dbprefix}contact_meta.meta_key = 'lat' THEN {$this->db->dbprefix}contact_meta.meta_value END) AS 'lat',
		 MAX(CASE WHEN {$this->db->dbprefix}contact_meta.meta_key = 'lng' THEN {$this->db->dbprefix}contact_meta.meta_value END) AS 'lng'");
				 $this->db->from("contacts");
         $this->db->join("contact_meta","contacts.id_contact = contact_meta.contact_id","left");
         $this->db->group_by("id_contact");
         $this->db->having("cast(lat as DECIMAL(10,3)) <= '{$north}'");
				 $this->db->having("cast(lat as DECIMAL(10,3)) >= '{$south}'");
				 $this->db->having("cast(lng as DECIMAL(10,3)) <= '{$east}'");
				 $this->db->having("cast(lng as DECIMAL(10,3)) >= '{$west}'");
				 $this->db->where("contacts.deleted",0);
				 $coordinates = $this->db->get();
				 $this->db->cache_off();
		     return $coordinates->num_rows();
    }

    public function search_locs($search){

     $this->db->select("
         'contact' as module,
				 'bigcity.png' as icon,contacts.id_contact as idc,
				 contacts.display_name as name,
				 MAX(CASE WHEN {$this->db->dbprefix}contact_meta.meta_key = 'city' THEN {$this->db->dbprefix}contact_meta.meta_value END) AS 'city',
				 MAX(CASE WHEN {$this->db->dbprefix}contact_meta.meta_key = 'adress' THEN {$this->db->dbprefix}contact_meta.meta_value END) AS 'adress',
				 MAX(CASE WHEN {$this->db->dbprefix}contact_meta.meta_key = 'num_adress' THEN {$this->db->dbprefix}contact_meta.meta_value END) AS 'num_adress',
				 MAX(CASE WHEN {$this->db->dbprefix}contact_meta.meta_key = 'lat' THEN {$this->db->dbprefix}contact_meta.meta_value END) AS 'lat',
         MAX(CASE WHEN {$this->db->dbprefix}contact_meta.meta_key = 'lng' THEN {$this->db->dbprefix}contact_meta.meta_value END) AS 'lng'
				 ");
				 $this->db->from("contacts");
         $this->db->join("contact_meta","contacts.id_contact = contact_meta.contact_id","left");
				 $this->db->like("display_name",$search);
				 $this->db->having("lat <>",'NULL');
				 $this->db->having("lng <>",'NULL');
         $this->db->group_by("id_contact");

				 $coordinates = $this->db->get();
		     return $coordinates->result_array();
    }


    //--------------------------------------------------------------------------
    // !META METHODS
    //--------------------------------------------------------------------------

    /**
     * Retrieve all meta values defined for a user.
     *
     * @param int   $user_id The ID of the user for which the meta will be retrieved.
     * @param array $fields  The meta_key names to retrieve.
     *
     * @return stdClass An object with the key/value pairs, or an empty object.
     */
    public function find_meta_for($user_id = null, $fields = null){

        // Is $user_id the right data type?
        if (! is_numeric($user_id)) {
            $this->error = lang('us_invalid_user_id');
            return new stdClass();
        }

        // Limiting to certain fields?
        if (! empty($fields) && is_array($fields)) {
            $this->where_in('meta_key', $fields);
        }

        $this->where('contact_id', $user_id);

        $query = $this->db->get($this->meta_table);

        $result = new stdClass();
        foreach ($query->result() as $row) {
            $key = $row->meta_key;
            $result->{$key} = $row->meta_value;
        }


        return $result;
    }

    /**
     * Locate a single user and the user's meta information.
     *
     * @param int $user_id The ID of the user to fetch.
     *
     * @return bool|object An object with the user's profile and meta information,
     * or false on failure.
     */
    public function find_user_and_meta($user_id = null)
    {
        // Is $user_id the right data type?
        if (! is_numeric($user_id)) {
            $this->error = lang('us_invalid_user_id');
            return false;
        }

        // Does a user with this $user_id exist?
        $result = $this->find($user_id);
        if (! $result) {
            $this->error = lang('us_invalid_user_id');
            return false;
        }

        // Get the meta data for this user and join it to the user profile data.
        $this->where('contact_id', $user_id);
        $query = $this->db->get($this->meta_table);
        foreach ($query->result() as $row) {
            $key = $row->meta_key;
            $result->{$key} = $row->meta_value;
        }

        return $result;
    }

    /**
     * Save one or more key/value pairs of meta information for a contact.
     *
     * @example
     * $data = array(
     *    'cpf'    => '234234343',
     *    'cnpj'   => '3324324233333'
     * );
     * $this->contact_model->save_meta_for($user_id, $data);
     *
     * @param int   $user_id The ID of the contact for which to save the meta data.
     * @param array $data    An array of key/value pairs to save.
     *
     * @return bool True on success, else false.
     */
    public function save_meta_for($user_id = null, $data = [])
    {
        // Is $user_id the right data type?
        if (! is_numeric($user_id)) {
            $this->error = lang('us_invalid_user_id');
            return false;
        }

        // If there's no data, get out of here.
        if (empty($data)) {
            return true;
        }

        $result = false;
        $successCount = 0;
        foreach ($data as $key => $value) {
            $obj = [
                'meta_key'   => $key,
                'meta_value' => $value,
                'contact_id'    => $user_id,
            ];
            $where = [
                'meta_key' => $key,
                'contact_id'  => $user_id,
            ];

            // Determine whether the data needs to be updated or inserted.
            $this->where($where);
            $query = $this->db->get($this->meta_table);
            $row = $query->row();
            if (isset($row)) {
                $result = $this->db->update($this->meta_table, $obj, $where);
            } else {
                $result = $this->db->insert($this->meta_table, $obj);
            }

            // Count the number of successful insert/update results.
            if ($result) {
                ++$successCount;
            }
        }

        return $successCount == count($data);
    }


		public function add_user_contact($id_contact,$id_user){

			$data = array(
				'contact_id'=>$id_contact,
				'user_id'=>$id_user
			);

			$this->db->insert('contacts_users',$data);

		}

		public function find_contacts_user($id_user){

		$data = array(
			'user_id'=>$id_user,
			'contacts.deleted'=>0
		);

		$this->db->select('id_contact,slug_contact,display_name,email');
		$this->db->from('contacts_users');
		$this->db->join('contacts','contacts.id_contact = contacts_users.contact_id','left');
		$this->db->where($data);
		$result = $this->db->get();

		if($result->num_rows()){ return $result->result(); }else{ return false; }

}

	public function find_contacts_user_ids($id_user){

		$data = array(
			'user_id'=>$id_user
		);

		$this->db->select('GROUP_CONCAT(distinct contact_id) as ids');
		$this->db->from('contacts_users');
		$this->db->where($data);
		$result = $this->db->get();

		if($result->num_rows()){ return $result->row()->ids; }else{ return false; }

	}

	public function find_users_contact_ids($id_contact){

		$data = array(
			'contact_id'=>$id_contact
		);

		$this->db->select('GROUP_CONCAT(distinct user_id) as ids');
		$this->db->from('contacts_users');
		$this->db->where($data);
		$result = $this->db->get();

		if($result->num_rows()){ return $result->row()->ids; }else{ return false; }

	}

	public function filter_input(){

		if(isset($_GET['term']) and !empty($_GET['term'])){ $this->db->like("contacts.display_name",$this->db->escape_str($_GET['term'])); }
		if(isset($_GET['contact_type']) and $_GET['contact_type'] != 0){ $this->db->where("contacts.contact_type",$_GET['contact_type']);}
		if(isset($_GET['city']) and !empty($_GET['city'])){ $this->db->having("city",$_GET['city']);}

	}

	public function get_contacts($offset,$limit){

		$this->filter_input();

		$where = array('contacts.deleted'=>0);

		$this->db->select("MAX(CASE WHEN meta_key = 'city' THEN meta_value END) AS 'city',
			id_contact,display_name,contact_type,slug_contact,phone,email,contacts.created_on as created_on");
		$this->db->join('contact_meta','contact_meta.contact_id = contacts.id_contact','left');

		$this->db->limit($limit, $offset)->where($where);
		$this->db->order_by('display_name','asc');
		$this->db->group_by('id_contact');

		return $this->db->get($this->table_name);

	}

	public function count_contacts(){

		$this->filter_input();

		$where = array('contacts.deleted'=>0);

		$this->db->select("id_contact");
		$this->db->where($where);
		$this->db->group_by('id_contact');
		$this->db->join('contact_meta','contact_meta.contact_id = contacts.id_contact','left');
		return $this->db->get($this->table_name)->num_rows();

	}

}
