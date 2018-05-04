<?php defined('BASEPATH') || exit('No direct script access allowed');

/**
 * Contact controller
 */
class Contact extends Front_Controller{

    protected $permissionCreate = 'Contact.Content.Create';
    protected $permissionDelete = 'Contact.Content.Delete';
    protected $permissionEdit   = 'Contact.Content.Edit';
    protected $permissionView   = 'Contact.Content.View';

    /**
     * Constructor
     *
     * @return void
     */
    public function __construct(){

        parent::__construct();

        $this->load->library('users/auth');
        $this->set_current_user();

        $this->load->model('contact/contact_model');

        $this->lang->load('contact/contact');
        $this->lang->load('contact/group');

        $this->load->helper('contact/contact');

        $this->load->library('users/Online_Users');

        $this->load->library('contact/Nested_set');
        $this->nested_set->setControlParams('groups','lft','rgt','id_group','parent_group','group_name');


        Assets::add_module_css('contact', 'contact.css');
        Assets::add_module_js('contact','jquery.geocomplete.min.js');
        Assets::add_module_js('contact', 'contact.js');
        Assets::add_module_js('contact', 'group.js');
        Assets::add_module_js('contact', 'group_contact.js');

        $this->form_validation->set_error_delimiters("<span class='error'>", "</span>");

    }




    /**
     * Display a list of Contact data.
     *
     * @return void
     */
    public function index(){

      $this->auth->restrict($this->permissionView,'desktop');
      $this->online_users->run_online();


      if (isset($_POST['delete'])) {
          $checked = $this->input->post('checked');
          if (empty($checked)) {
              // No users checked.
              Template::set_message(lang('us_empty_id'), 'error');
          } else {
              foreach ($checked as $userId) {
                  $this->delete($userId);
              }
          }
      }

      $offset = $this->uri->segment(3);
      $where = array('contacts.deleted'=>0);

      $this->contact_model->limit($this->limit, $offset)->where($where);
      $this->db->order_by('display_name','asc');
      $contacts = $this->contact_model->find_all();

      $this->load->library('pagination');

      $this->pager['base_url']    = base_url()."contact/index/";
      $this->pager['per_page']    = $this->limit;
      $this->pager['total_rows']  = $this->contact_model->where($where)->count_all();
      $this->pager['uri_segment'] = 3;

      $this->pagination->initialize($this->pager);

      Template::set('toolbar_title', lang('contact_list'));
      Template::set('contatos', $contacts);

      Template::set_block('sub_nav_menu', '_menu_module');
      Template::render('mod_index');

    }


    /**
     * Create a Contact object.
     *
     * @return void
     */
    public function create(){

        $this->auth->restrict($this->permissionCreate);

        $this->load->config('contact_meta');
        $meta_fields = config_item('person_meta_fields');
        $this->load->config('address');
        $this->load->helper('address');

        $this->load->model('contact/group_model');

        $sell_redirect = $this->uri->segment(3,0);

        if (isset($_POST['save'])) {

            if ($insert_id = $this->save_contact('insert',0,$meta_fields)) {

              $data_insert = array('contact_id'=>$insert_id,'post_data'=>$_POST);

              Events::trigger('insert_contact',$data_insert);

              $id_act = log_activity($this->auth->user_id(), lang('contact_act_create_record') . ': ' . $this->contact_model->find($insert_id)->display_name , 'contact');

              log_notify($this->user_model->get_id_users_role('id',array(4,1)), $id_act);

              Template::set_message(lang('contact_create_success'), 'success');

               if($sell_redirect){ Template::redirect('sells/create/'.$insert_id); } else { Template::redirect('contacts');  }
            }

            // Not validation error
            if ( ! empty($this->contact_model->error)) {
                Template::set_message(lang('contact_create_failure') . $this->contact_model->error, 'error');
            }
        }

        $data_html = array('html'=>'');
        Events::trigger('show_create_contact',$data_html);
        Template::set('data_html',$data_html['html']);
        Template::set('groups',$this->group_model->find_all());
        Template::set('meta_fields',$meta_fields);
        Template::set('toolbar_title', lang('contact_action_create'));

        $parent_node = $this->nested_set->getNodeWhere(array('id_group'=>1));
        $tree = $this->nested_set->getSubTree($parent_node);

        Template::set('tree', $tree);

        Template::set_block('sub_nav_menu', '_menu_module');
        Template::render('mod_index');
    }
    /**
     * Allows editing of Contact data man.
     *
     * @return void
     */
    public function edit(){


        $this->auth->restrict($this->permissionEdit,'desktop');

        $id = $this->uri->segment(3);
        if (empty($id)) {
            Template::set_message(lang('contact_invalid_id'), 'error');
            redirect('contacts');
        }

        $id = $this->contact_model->find_by('slug_contact',$id)->id_contact;

        $this->load->model('contact/group_model');
        $meta_fields = config_item('person_meta_fields');
        $this->load->config('address');
        $this->load->helper('address');

        if (isset($_POST['save'])) {

          $this->auth->restrict($this->permissionEdit);

          $this->load->config('contact_meta');
          $type = $this->input->post('contact_type');
          $meta_fields = config_item('person_meta_fields');

          if($type == 2){  $meta_fields = config_item('company_meta_fields');   }

            if ($this->save_contact('update', $id, $meta_fields)) {
                log_activity($this->auth->user_id(), lang('contact_act_edit_record') . ': ' . $id . ' : ' . $this->input->ip_address(), 'contact');
                Template::set_message(lang('contact_edit_success'), 'success');
                redirect('contacts');
            }

            // Not validation error
            if ( ! empty($this->contact_model->error)) {
                Template::set_message(lang('contact_edit_failure') . $this->contact_model->error, 'error');
            }
        }



        $data_html = array('html'=>'');
        Events::trigger('show_create_contact',$data_html);
        Template::set('data_html',$data_html['html']);

        $contact = $this->contact_model->find_user_and_meta($id);

        Template::set('contact', $contact);
        Template::set('my_groups', $this->group_model->get_contact_groups_array($id));

        $parent_node = $this->nested_set->getNodeWhere(array('id_group'=>1));
        $tree = $this->nested_set->getSubTree($parent_node);

        Template::set('tree', $tree);

        Template::set('toolbar_title', lang('contact_edit_heading'));
        Template::set_view('create');
        Template::set_block('sub_nav_menu', '_menu_module');
        Template::render('mod_index');
    }

    //--------------------------------------------------------------------------
    // !PRIVATE METHODS
    //--------------------------------------------------------------------------

    private function delete($id){

      $contact = $this->contact_model->find($id);
      if (! isset($contact)) {
          Template::set_message(lang('us_invalid_contact_id'), 'error');
          Template::redirect('contacts');
      }

          $this->auth->restrict($this->permissionDelete);

          if ($this->contact_model->delete($id)) {

              $id_act = log_activity($this->auth->user_id(), lang('contact_act_delete_record') . ': ' . $contact->display_name , 'contact');
              log_notify($this->user_model->get_id_users_role('id',array(4,1)), $id_act);

              Template::set_message(lang('contact_delete_success'), 'success');
              return;
          }

          Template::set_message(lang('contact_delete_failure') . $this->contact_model->error, 'error');

    }

    /**
     * Save the data.
     *
     * @param string $type Either 'insert' or 'update'.
     * @param int    $id   The ID of the record to update, ignored on inserts.
     *
     * @return boolean|integer An ID for successful inserts, true for successful
     * updates, else false.
     */

    private function save_contact($type = 'insert', $id = 0,$metaFields = array()){

      $extraUniqueRule = '';

        if ($type == 'update') {
            $_POST['id_contact'] = $id;

              $extraUniqueRule = ',contacts.id_contact';

        }

        $metaData = array();
        foreach ($metaFields as $field) {
                $this->form_validation->set_rules($field['name'], $field['label'], $field['rules']);
                $metaData[$field['name']] = $this->input->post($field['name']);
            }


        // Validate the data
        $this->form_validation->set_rules($this->contact_model->get_validation_rules());

          $this->form_validation->set_rules('email', 'lang:contact_field_email', "unique[contacts.email{$extraUniqueRule}]|trim|valid_email|max_length[255]");
          $this->form_validation->set_rules('phone', 'lang:contact_field_phone', "unique[contacts.phone{$extraUniqueRule}]|trim|max_length[20]");

        if ($this->form_validation->run() === false) {
            return false;
        }

        // Make sure we only pass in the fields we want

        $data = $this->contact_model->prep_data($this->input->post());

        $config = array(
            'field' => 'slug_contact',
            'title' => 'display_name',
            'table' => 'contacts',
            'id' => 'id_contact',
        );

        $this->load->library('slug', $config);
        $data['slug_contact'] = $this->slug->create_uri($this->input->post('display_name'));

        // Additional handling for default values should be added below,
        // or in the model's prep_data() method

        $return = false;
        if ($type == 'insert') {
            $id = $this->contact_model->insert($data);

            if (is_numeric($id)) {
                $return = $id;
            }
        } elseif ($type == 'update') {
            $return = $this->contact_model->update($id, $data);
        }


        if (is_numeric($id) && ! empty($metaData)) {
            $this->contact_model->save_meta_for($id, $metaData);
        }

        return $return;
    }


     public function profile(){

       $this->auth->restrict($this->permissionView,'/desktop');

       $this->online_users->run_online();

           $id = $this->uri->segment(2);

           if (empty($id)) {
               Template::set_message(lang('contact_invalid_id'), 'error');
               redirect('contact');
           }

           if($id = $this->contact_model->find_by('slug_contact',$id)->id_contact){

           $contact = $this->contact_model->find_user_and_meta($id);

           $modules = Modules::list_modules(true);

           $tabs = array();

             foreach($modules as $module) :
               $config = Modules::config($module);
               if(isset($config['tab_contact']) and $config['tab_contact']['url']){
               array_push($tabs,$config['tab_contact']);
            }

           endforeach;

           if(count($tabs)){

           $function = $this->uri->segment(3,$tabs[0]['url']);

           $data = array('function'=>$function,'view_page'=>'','id_contact'=>$id,'data_table'=>'');

           Events::trigger('show_profile_contact',$data);

           Template::set('function_tab',$function);

           Template::set('data',$data['data_table']);

           Template::set('view_page', $data['view_page']);

           }

           Template::set('tabs',$tabs);
           Template::set('contact', $contact);
           Template::set('toolbar_title', $contact->display_name);
           Template::render();

         }else{

           Template::set_message(lang('contact_invalid_id'), 'error');
           redirect('contact');
         }

     }



    public function geral_search(&$data){

       if (has_permission($this->permissionView)) {

         $results = $this->contact_model->search_general($data['term'],array('id_contact','email','slug_contact','display_name','phone'),$this->limit,$data['offset']);

         $html = array();

       foreach($results->result() as $result){

         array_push($html,array('<hr><div class="media">
  <img class="mr-3" src="'.gravatar_link($result->email, 64, $result->email, $result->email).'" alt="contact_photo">
  <div class="media-body">
    <h5 class="mt-0">'.anchor('contato/'.$result->slug_contact,$result->display_name).'</h5>'.
    $result->phone.'</br>'.anchor('contact/edit/'.$result->slug_contact,'edit').'
  </div>
</div>'));

       }

       $this->db->like('display_name',$data['term']);
       $this->db->where('deleted',0);
       $total = $this->contact_model->count_all();

       array_push($data['data'],array('module'=>'contacts','result'=>$html,'total'=>$total));

     }
   }

   public function ajax_search(&$records){

    $this->db->select("id_contact,email,phone,display_name");
    $this->db->from('contacts');
    $this->db->like('display_name',$this->input->get('query'));
    $contacts = $this->db->get();

    $result = array();

    foreach($contacts->result() as $contact){

      $meta = $this->contact_model->find_meta_for($contact->id_contact,array('city','neibor','adress','num_adress','lat','lng'));

      $coord = (isset($meta->lat) and !empty($meta->lat))? $meta->lat.', '.$meta->lng:0;

      $adress = (isset($meta->adress) and !empty($meta->adress) and !empty($meta->num_adress))? $meta->city.', '.$meta->neibor.' <br/> '.$meta->adress.' - '.$meta->num_adress: 'Endereço incompleto.';

    array_push($result,array(
    'url'=>'',
    'id' => $contact->id_contact,
    'idc'=> $contact->id_contact,
    'email'=> $contact->email,
    'phone'=> $contact->phone,
    'name'=> ucfirst($contact->display_name),
    'descc'=> $adress,
    'address'=> $adress,
    'city'=> $meta->city,
    'neibor'=> $meta->neibor,
    'num_address'=> $meta->num_adress,
    'coord'=> $coord
    ));


    }

    array_push($records,$result);

   }


     function get_markers(&$data_json){

       array_push($data_json['markers'],$this->contact_model->get_markersbound($data_json['north'],$data_json['south'],$data_json['east'],$data_json['west']));

     }


     function get_groups(){

       $term = $this->input->post('search');

       $records = $result = array();

       Events::trigger('search_groups',$records);

       foreach($records as $ind => $record){
            foreach($records[$ind] as $sugest){

           array_push($result,
                 array(
                 'value'=>$sugest->id_group,
                 'text'=>word_limiter($sugest->group_name, 5)
                 ));
             }
         }


       $this->output->set_output(json_encode($result));

     }


     public function create_access(){

       $this->auth->restrict($this->permissionCreate);
       $this->online_users->run_online();

           $id = $this->uri->segment(3);

           if (empty($id)) {
               Template::set_message(lang('contact_invalid_id'), 'error');
               redirect('contacts');
           }

       if($id = $this->contact_model->find_by('slug_contact',$id)->id_contact){

       $contact = $this->contact_model->find_user_and_meta($id);
       $this->load->model('roles/role_model');
       Template::set(
           'roles',
           $this->role_model->select('role_id, role_name, default')
                            ->where('deleted', 0)
                            ->order_by('role_name', 'asc')
                            ->find_all()
       );

       Template::set('contact', $contact);
       Template::set('view_page', 'create_access');
       Template::set('toolbar_title', $contact->display_name);
       Template::set_view('profile');
       Template::render();

     }else{

       Template::set_message(lang('contact_invalid_id'), 'error');
       redirect('contacts');
     }
    }

		 public function Create_user_contact($data){

			 $user = $this->user_model->find_user_and_meta($data);

			 $config = array(
					 'field' => 'slug_contact',
					 'title' => 'display_name',
					 'table' => 'contacts',
					 'id' => 'id_contact',
			 );

			 $this->load->library('contact/slug', $config);

			 $contact_data = array(
				 'display_name'=> $user->display_name,
				 'slug_contact'=> $this->slug->create_uri($user->display_name),
				 'email'=> $user->email,
				 'timezone'=> $user->timezone,
			 );

			 $this->db->insert('contacts',$contact_data);
			 $id = $this->db->insert_id();

			 $contact_data_meta = array(
				 'meta_key'=> 'is_user',
				 'meta_value'=> $user->id,
				 'contact_id'=> $id
			 );

			 $this->db->insert('contact_meta',$contact_data_meta);

			 $contact_data_meta_country = array(
				 'meta_key'=> 'country',
				 'meta_value'=> $user->country,
				 'contact_id'=> $id
			 );

			 $this->db->insert('contact_meta',$contact_data_meta_country);

			 $contact_data_meta_state = array(
				 'meta_key'=> 'state',
				 'meta_value'=> $user->state,
				 'contact_id'=> $id
			 );

			 $this->db->insert('contact_meta',$contact_data_meta_state);

		 }
}
