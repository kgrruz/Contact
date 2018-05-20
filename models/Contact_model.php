<?php defined('BASEPATH') || exit('No direct script access allowed');

class Contact_model extends BF_Model{


	protected $table_name	= 'contacts';
	protected $key			  = 'id_contact';
	protected $date_format	= 'datetime';
	protected $meta_table   = 'contact_meta';

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
			'field' => 'display_name',
			'label' => 'lang:contact_field_display_name',
			'rules' => 'required|trim|max_length[255]',
		),
		array(
			'field' => 'timezone',
			'label' => 'lang:contact_field_timezone',
			'rules' => 'trim|alpha_numeric|max_length[10]',
		),
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

      $like = array('display_name' => $term);
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

    function search_list_json($term){
			
      $like = array('display_name' => $term);
      $this->db->select("contacts.id_contact as value,contacts.display_name as text");
      $this->db->from('contacts');
      $this->db->where('deleted', 0);
      $this->db->like($like);
      $this->db->limit(5);
      $query = $this->db->get()->result();

      return $query;

    }

    public function get_markersbound($north,$south,$east,$west){

     $coordinates = $this->db->query("
         SELECT
         c.id_contact as idc,c.display_name as name, c.contact_type, MAX(CASE WHEN m.meta_key = 'lat' THEN m.meta_value END) AS 'lat',
         MAX(CASE WHEN m.meta_key = 'lng' THEN m.meta_value END) AS 'lng' FROM contacts c
         INNER JOIN contact_meta m ON c.id_contact = m.contact_id
         GROUP BY c.id_contact
         HAVING lat <= $north and lat >= $south and lng <= $east and lng >= $west
     ");

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

			$this->db->cache_on();

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


				$this->db->cache_off();

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




	}
