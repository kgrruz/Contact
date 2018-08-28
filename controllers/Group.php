<?php defined('BASEPATH') || exit('No direct script access allowed');

/**
 * Group controller
 */
class Group extends Front_Controller{

    protected $permissionCreate = 'Contact.Content.Create';
    protected $permissionDelete = 'Contact.Content.Delete';
    protected $permissionEdit   = 'Contact.Content.Edit';
    protected $permissionView   = 'Contact.Content.View';

    /**
     * Constructor
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();


        $this->load->model('group_model');
        $this->lang->load('group');
        $this->lang->load('contact');

        $this->load->library('users/Online_Users');
        $this->load->library('contact/Nested_set');

        $this->nested_set->setControlParams('groups','lft','rgt','id_group','parent_group','group_name');

        $this->form_validation->set_error_delimiters("<span class='error'>", "</span>");

    }


    /**
     * Display a list of Group data.
     *
     * @return void
     */
    public function index(){

      $this->authenticate($this->permissionView);


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


      $parent_node = $this->nested_set->getNodeWhere(array('id_group'=>1));
      $tree = $this->nested_set->getSubTree($parent_node);

      Template::set('tree', $tree);
      Template::set('toolbar_title', lang('group_list'));

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

        if (isset($_POST['save'])) {

            if ($insert_id = $this->save_group('insert')) {

                log_activity($this->auth->user_id(), lang('group_act_create_record') . ': ' . $insert_id . ' : ' . $this->input->ip_address(), 'group');

                $payload = array('group_name'=>$this->input->post('group_name'),'group_description'=>$this->input->post('description'));
                Events::trigger('after_group_create',$payload);

                Template::set_message(lang('group_create_success'), 'success');
                Template::redirect('contact/group');
            }

            // Not validation error
            if ( ! empty($this->group_model->error)) {
                Template::set_message(lang('group_create_failure') . $this->group_model->error, 'error');
            }
        }


        Template::set('toolbar_title', lang('group_action_create'));

        $parent_node = $this->nested_set->getNodeWhere(array('id_group'=>1));
        $tree = $this->nested_set->getSubTree($parent_node);

        Template::set('tree', $tree);

        Template::set_block('sub_nav_menu', '_menu_module');
        Template::render('mod_index');
    }


    public function edit(){

        $id = $this->uri->segment(4);
        if (empty($id)) {
            Template::set_message(lang('group_invalid_id'), 'error');
            redirect('contact/group');
        }

        $id = $this->group_model->find_by('slug_group',$id)->id_group;

        if (isset($_POST['save'])) {

           $this->authenticate($this->permissionEdit);

            if ($this->save_group('update', $id)) {
                log_activity($this->auth->user_id(), lang('group_act_edit_record') . ': ' . $id . ' : ' . $this->input->ip_address(), 'group');
                Template::set_message(lang('group_edit_success'), 'success');
                redirect('contact/group');
            }

            // Not validation error
            if ( ! empty($this->group_model->error)) {
                Template::set_message(lang('group_edit_failure') . $this->group_model->error, 'error');
            }
        }



        $group = $this->group_model->find($id);

        Template::set('group', $group);
        Template::set('toolbar_title', lang('group_edit_heading'));
        Template::set_view('group/create');

        $parent_node = $this->nested_set->getNodeWhere(array('id_group'=>1));
        $this->db->where('id_group <>',$group->id_group);
        $tree = $this->nested_set->getSubTree($parent_node);

        Template::set('tree', $tree);
        Template::set_block('sub_nav_menu', '_menu_module');
        Template::render('mod_index');

    }

    //--------------------------------------------------------------------------
    // !PRIVATE METHODS
    //--------------------------------------------------------------------------

    private function delete($id){

      $group = $this->group_model->find($id);
      if (! isset($group)) {
          Template::set_message(lang('us_invalid_group_id'), 'error');
          Template::redirect('contact/group');
      }

          $this->auth->restrict($this->permissionDelete);

          $node = $this->nested_set->getNodeWhere('id_group = '.$id);

          if ($this->nested_set->deleteNode($node)) {

              $id_act = log_activity($this->auth->user_id(), lang('group_act_delete_record') . ': ' . $group->group_name , 'group');
              log_notify($this->user_model->get_id_users_role('id',array(4,1)), $id_act);

              Template::set_message(lang('group_delete_success'), 'success');
              return;
          }

          Template::set_message(lang('group_delete_failure') . $this->group_model->error, 'error');

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
    private function save_group($type = 'insert', $id = 0){

        $extraUniqueRule = '';
        
        if ($type == 'update') {
            $_POST['id_group'] = $id;

              $extraUniqueRule = ',groups.id_group';
        }


        // Validate the data
        $this->form_validation->set_rules($this->group_model->get_validation_rules());

        $this->form_validation->set_rules('group_name', 'lang:group_field_group_name', "unique[groups.group_name{$extraUniqueRule}]|trim|max_length[255]");


        if ($this->form_validation->run() === false) {
            return false;
        }

        // Make sure we only pass in the fields we want

        $data = $this->group_model->prep_data($this->input->post());

        // Additional handling for default values should be added below,
        // or in the model's prep_data() method
        $config = array(
            'field' => 'slug_group',
            'title' => 'group_name',
            'table' => 'groups',
            'id' => 'id_group',
        );

        $this->load->library('slug', $config);
        $data['slug_group'] = $this->slug->create_uri($this->input->post('group_name'));


        $return = false;
        if ($type == 'insert') {

            //$id = $this->group_model->insert($data);
            $data_insert = array(
              'group_name'=>$this->input->post('group_name'),
              'description'=>$this->input->post('description'),
              'slug_group'=>$data['slug_group'],
              'created_by'=>1,
              'created_on'=>date('Y-m-d H:i:s')
            );

            $parent_node = $this->nested_set->getNodeWhere(array('id_group'=>$this->input->post('parent_group')));
            $node = $this->nested_set->insertNewChild($parent_node,$data_insert);
            $id   = $node['id_group'];

            if (is_numeric($id)) {
                $return = $id;
            }
        } elseif ($type == 'update') {



            $parent_node = $this->nested_set->getNodeWhere(array('id_group'=>$this->input->post('parent_group')));
            $node = $this->nested_set->getNodeFromId($id);

            $this->nested_set->setNodeAsFirstChild($node,$parent_node);


            $return = $this->group_model->update($id, $data);

        }



        return $return;
    }


    public function search_groups(&$records){

      array_push($records,$this->group_model->search_groups_json($this->input->post('search')));

        }


        public function _add_to_group(&$data){

          $groups = (isset($data['post_data']['group']))? $data['post_data']['group']:array();

          if(count($groups) > 0){

          foreach($groups as $group){

            $this->db->insert('contacts_groups',array('id_contact_join'=>$data['contact_id'],'id_group_join'=>$group));

            }
          }
        }

        public function page(){

            $id = $this->uri->segment(4);
            if (empty($id)) {
                Template::set_message(lang('group_invalid_id'), 'error');
                redirect('contact/group');
            }

            $id = $this->group_model->find_by('slug_group',$id)->id_group;

            $group = $this->group_model->find($id);
            $contacts = $this->group_model->get_contacts_in_group($id);

            Template::set('group', $group);
            Template::set('contacts', $contacts);
            Template::set('toolbar_title', $group->group_name);
            Template::set_view('group/page');

            Template::set_block('sub_nav_menu', '_menu_module');
            Template::render('mod_index');

  }
  }
