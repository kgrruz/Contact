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

        $this->load->model('contact/contact_model');

        $this->lang->load('contact/contact');
        $this->lang->load('contact/group');

        $this->load->helper('contact/contact');
        $this->load->library('contact/Nested_set');

        $this->nested_set->setControlParams('groups','lft','rgt','id_group','parent_group','group_name');

        Assets::add_module_js('contact', 'locales.js');

        Assets::add_module_css('contact', 'contact.css');

        Assets::add_module_js('contact', 'contact.js');
        Assets::add_module_js('contact', 'group.js');
        Assets::add_module_js('contact', 'group_contact.js');

        $this->form_validation->set_error_delimiters("<span class='danger'>", "</span>");

    }

    /**
     * Display a list of Contact data.
     *
     * @return void
     */
    public function index(){

      $this->authenticate($this->permissionView,'desktop');

      $offset = $this->uri->segment(3);
      $where = array('contacts.deleted'=>0);

      if(isset($_GET['term']) and !empty($_GET['term'])){ $this->contact_model->like("contacts.display_name",$_GET['term']); }
      if(isset($_GET['contact_type']) and $_GET['contact_type'] != 0){ $this->contact_model->where("contacts.contact_type",$_GET['contact_type']);}
      if(isset($_GET['city']) and !empty($_GET['city'])){ $this->contact_model->having("city",$_GET['city']);}

      $this->contact_model->limit($this->limit, $offset)->where($where);
      $this->db->order_by('display_name','asc');
      $this->db->group_by('id_contact');
      $this->contact_model->select("
        MAX(CASE WHEN meta_key = 'is_user' THEN meta_value END) AS 'is_user',
        MAX(CASE WHEN meta_key = 'city' THEN meta_value END) AS 'city',
        id_contact,display_name,contact_type,slug_contact,phone,email,contacts.created_on as created_on
        ");
      $this->contact_model->join('contact_meta','contact_meta.contact_id = contacts.id_contact','left');
      $contacts = $this->contact_model->find_all();

      $this->load->library('pagination');

      $this->pager['base_url']    = base_url()."contact/index/";
      $this->pager['per_page']    = $this->limit;
      $this->pager['reuse_query_string'] = true;

      if(isset($_GET['term']) and !empty($_GET['term'])){ $this->contact_model->like("contacts.display_name",$_GET['term']); }
      if(isset($_GET['contact_type']) and $_GET['contact_type'] != 0){ $this->contact_model->where("contacts.contact_type",$_GET['contact_type']);}
      if(isset($_GET['city']) and !empty($_GET['city'])){ $this->contact_model->having("city",$_GET['city']);}

      $this->db->group_by('id_contact');
      $this->contact_model->select("
        MAX(CASE WHEN meta_key = 'is_user' THEN meta_value END) AS 'is_user',
        MAX(CASE WHEN meta_key = 'city' THEN meta_value END) AS 'city',
        id_contact,display_name,contact_type,slug_contact,phone,email,contacts.created_on as created_on
        ");
      $this->contact_model->join('contact_meta','contact_meta.contact_id = contacts.id_contact','left');
      $this->pager['total_rows']  = $this->contact_model->where($where)->count_all();
      $this->pager['uri_segment'] = 3;

      $this->pagination->initialize($this->pager);

      Template::set('cities', $this->contact_model->cities_contacts());

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

        $this->authenticate($this->permissionCreate);

        $this->load->config('contact_meta');

        $this->load->config('address');
        $this->load->helper('address');

        $this->load->model('contact/group_model');

        $sell_redirect = $this->uri->segment(3,0);

        if (isset($_POST['save'])) {

            if($_POST['contact_type'] == 1){ $meta_fields = config_item('person_meta_fields'); }else{ $meta_fields = config_item('company_meta_fields'); }

            if ($insert_id = $this->save_contact('insert',0,$meta_fields)) {

              $data_insert = array('contact_id'=>$insert_id,'post_data'=>$_POST);

              Events::trigger('insert_contact',$data_insert);

              $inserted_contact = $this->contact_model->find($insert_id);

              // TODO: fix relative url
              $msg_event = '[contact_act_create_record]' . ': ' . '<a href="contato/'.$inserted_contact->slug_contact.'">'.$inserted_contact->display_name.'</a>';

              $data_sse = array('event'=>'refresh_not','msg'=>$msg_event,'to'=>array(4,1),'timestamp'=>now());

              Events::trigger('sse_event',$data_sse);

              $id_act = log_activity($this->auth->user_id(), $msg_event , 'contact');

              log_notify($this->auth->users_has_permission($this->permissionView), $id_act);

              Template::set_message(lang('contact_create_success'), 'success');

             Template::redirect('contato/'.$inserted_contact->slug_contact);

            }

            // Not validation error
            if ( ! empty($this->contact_model->error)) {
                Template::set_message(lang('contact_create_failure') . $this->contact_model->error, 'danger');
            }
        }

        $type = $this->uri->segment(3,1);

        $data_html = array('html'=>'','type'=>$type);
        Events::trigger('show_create_contact',$data_html);
        Template::set('data_html',$data_html['html']);
        Template::set('groups',$this->group_model->find_all());

        $parent_node = $this->nested_set->getNodeWhere(array('id_group'=>1));
        $tree = $this->nested_set->getSubTree($parent_node);

        Template::set('tree', $tree);

        if($type == 1){

        $ext = " - ".lang('contact_contact');

        Template::set('selected_company',$this->uri->segment(4));
        $this->contact_model->where('contact_type',2);
        $this->contact_model->where('deleted',0);
        Template::set('companies', $this->contact_model->find_all());
        Template::set('job_roles', $this->contact_model->get_job_roles());

      }else{

        $ext = " - ".lang('contact_company');

      }

        Template::set('cities', $this->contact_model->cities_contacts());
        Template::set('toolbar_title', lang('contact_action_create').$ext);
        Template::set('contact_type', $type);
        Template::set_block('sub_nav_menu', '_menu_module');
        Template::render('mod_index');
    }

    public function ajax_create(){

      if (!$this->input->is_ajax_request()) {  exit('No direct script access allowed'); }

      $this->authenticate($this->permissionCreate);

      $this->load->config('contact_meta');
      $meta_fields = config_item('person_meta_fields');

      $this->load->model('contact/group_model');

      $sell_redirect = $this->uri->segment(3,0);

      if (isset($_POST['display_name'])) {

          if ($insert_id = $this->save_contact('insert',0,$meta_fields)) {

            $data_insert = array('contact_id'=>$insert_id,'post_data'=>$_POST);

            Events::trigger('insert_contact',$data_insert);

            $contact = $this->contact_model->find($insert_id);

            $id_act = log_activity($this->auth->user_id(), lang('contact_act_create_record') . ': ' . $contact->display_name , 'contact');

            log_notify($this->auth->users_has_permission($this->permissionView), $id_act);

            $this->output->set_output(json_encode(array('status'=>'success','idc'=>$insert_id,'image'=>gravatar_link($contact->email, 50, $contact->email, $contact->email), 'name'=>$contact->display_name,'message'=>lang('contact_create_success'))));

          }else{

              $this->output->set_output(json_encode(array('status'=>'danger','message'=>validation_errors())));

          }
      }
    }

    /**
     * Allows editing of Contact data man.
     *
     * @return void
     */
    public function edit(){

        $this->authenticate($this->permissionEdit);

        $id = $this->uri->segment(3);
        if (empty($id)) {
            Template::set_message(lang('contact_invalid_id'), 'danger');
            redirect('contacts');
        }

        $contact = $this->contact_model->find_by('slug_contact',$id);

        if($contact){

        $this->load->model('contact/group_model');
        $meta_fields = config_item('person_meta_fields');
        $this->load->config('address');
        $this->load->helper('address');

        if (isset($_POST['save'])) {

          $this->authenticate($this->permissionEdit);

          $this->load->config('contact_meta');
          $type = $this->input->post('contact_type');
          $meta_fields = config_item('person_meta_fields');

          if($type == 2){  $meta_fields = config_item('company_meta_fields');   }

            if($this->save_contact('update', $contact->id_contact, $meta_fields)) {

              $data_insert = array('contact_id'=>$contact->id_contact,'post_data'=>$_POST);

              Events::trigger('insert_contact',$data_insert);

                $id_act = log_activity($this->auth->user_id(), '[contact_act_edit_record]' . ' : ' . '<a href="contato/'.$contact->slug_contact.'">'.$contact->display_name.'</a>', 'contact');

                log_notify($this->auth->users_has_permission($this->permissionView), $id_act);

                Template::set_message(lang('contact_edit_success'), 'success');
                Template::redirect('contacts');
            }

            // Not validation error
            if ( ! empty($this->contact_model->error)) {
                Template::set_message(lang('contact_edit_failure') . $this->contact_model->error, 'danger');
            }
        }


        $contact_meta = $this->contact_model->find_user_and_meta($contact->id_contact);

        $data_html = array('html'=>'','contact'=>$contact_meta,'type'=>$contact->contact_type);
        Events::trigger('show_create_contact',$data_html);
        Template::set('data_html',$data_html['html']);

        Template::set('contact', $contact_meta);
        Template::set('my_groups', $this->group_model->get_contact_groups_array($contact->id_contact));

        $parent_node = $this->nested_set->getNodeWhere(array('id_group'=>1));
        $tree = $this->nested_set->getSubTree($parent_node);

        Template::set('tree', $tree);
        Template::set('contact_type', $contact->contact_type);

        if($contact->contact_type == 1){

        $ext = " - ".lang('contact_contact');

        if(isset($contact_meta->company) and $contact_meta->company != 0){ Template::set('selected_company',$contact_meta->company); }

        $this->contact_model->where('contact_type',2);
        Template::set('companies', $this->contact_model->find_all());
        Template::set('job_roles', $this->contact_model->get_job_roles());

      }else{

        $ext = " - ".lang('contact_company');

      }
      Template::set('cities', $this->contact_model->cities_contacts());

        Template::set('toolbar_title', lang('contact_edit_heading').$ext);
        Template::set_view('create');
        Template::set_block('sub_nav_menu', '_menu_module');
        Template::render('mod_index');

      }else{ show_error(lang('contact_invalid_id')); }
    }

    //--------------------------------------------------------------------------
    // !PRIVATE METHODS
    //--------------------------------------------------------------------------

    public function delete($id){

      $contact = $this->contact_model->find_user_and_meta($id);
      if (! isset($contact)) {
          Template::set_message(lang('us_invalid_contact_id'), 'danger');
          Template::redirect('contacts');
      }

          $this->authenticate($this->permissionDelete);

          if (!empty($contact->is_user)) {

              return lang('contact_has_user').'<br/>';
          }

          if ($this->contact_model->delete($id)) {

              $id_act = log_activity($this->auth->user_id(), '[contact_act_delete_record]' . ': '. '<a href="contato/'.$contact->slug_contact.'">'.$contact->display_name.'</a>', 'contact');
              log_notify($this->auth->users_has_permission($this->permissionView), $id_act);

              Template::set_message($contact->display_name.' '.lang('contact_delete_success'),'success');
              Template::redirect($this->agent->referrer());

          }

          return lang('contact_delete_failure') . $this->contact_model->error;

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
        $data['slug_contact'] = $this->slug->create_uri($this->input->post('display_name'),$id);

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

       $this->authenticate($this->permissionView);

           $id = $this->uri->segment(2);

           if (empty($id)) {
               Template::set_message(lang('contact_invalid_id'), 'danger');
               redirect('contacts');
           }

           if($id = $this->contact_model->find_by('slug_contact',$id)->id_contact){

           $contact = $this->contact_model->find_user_and_meta($id);

           if($contact->deleted){

             Template::set_message(lang('contact_is_deleted'), 'danger');
             redirect('contacts');

           }

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

           $data = array('function'=>$function,'view_page'=>'','contact_type'=>'','id_contact'=>$id,'data_table'=>'','slug'=>$contact->slug_contact);

           Events::trigger('show_profile_contact',$data);
           Template::set('function_tab',$function);

           Template::set('data',$data['data_table']);
           Template::set('contact_type',$data['contact_type']);
           Template::set('id_contact',$data['id_contact']);
           Template::set('view_page', $data['view_page']);

           }

           Template::set('tabs',$tabs);
           Template::set('contact', $contact);
           Template::set('toolbar_title', $contact->display_name);
           Template::render();

         }else{

           Template::set_message(lang('contact_invalid_id'), 'danger');
           redirect('contact');
         }

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
               Template::set_message(lang('contact_invalid_id'), 'danger');
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

       Template::set_message(lang('contact_invalid_id'), 'danger');
       redirect('contacts');
     }
    }

		 public function Create_user_contact($data){

			 $user = $this->user_model->find_user_and_meta($data['user_id']);

       if(!$this->user_model->find_contact_user($user->id) and $user->role_id == 4){

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
         'created_by'=>$user->id
			 );

			 $this->db->insert('contacts',$contact_data);
			 $id = $this->db->insert_id();

			 $contact_data_meta = array(
				 'meta_key'=> 'is_user',
				 'meta_value'=> $user->id,
				 'contact_id'=> $id
			 );

       $this->db->insert('contact_meta',$contact_data_meta);

			 $contact_data_meta2 = array(
				 'meta_key'=> 'country',
				 'meta_value'=> $user->country,
				 'contact_id'=> $id
			 );

       $this->db->insert('contact_meta',$contact_data_meta2);

			 $contact_data_meta3 = array(
				 'meta_key'=> 'state',
				 'meta_value'=> $user->state,
				 'contact_id'=> $id
			 );

       $this->db->insert('contact_meta',$contact_data_meta3);

      }
		 }

     public function info_popover($id){

       if (!$this->input->is_ajax_request()) {  exit('No direct script access allowed'); }

       $this->authenticate($this->permissionCreate);

       $contact = $this->contact_model->find($id);

       $this->output->set_output('
  <img class="card-img-top" src="'.contact_avatar($contact->email, 200,'card-img-top img-fluid w-100',false,'profile_photo').'" alt="Card image cap">
  <div class="card-body">
    <h5 class="card-title">'.$contact->display_name.'</h5>
    <p class="card-text">'.$contact->phone.'</p>
    </div>');

     }




}
