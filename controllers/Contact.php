<?php defined('BASEPATH') || exit('No direct script access allowed');

/**
 * Contact controller
 */
class Contact extends Front_Controller{
    /**
     * Constructor
     *
     * @return void
     */
    public function __construct(){

        parent::__construct();

        $this->lang->load('contact/contact');
        $this->load->model('users/user_model');
        $this->load->model('contact/contact_model');
        $this->load->library('users/auth');

      }

    

      public function profile($id){

        $this->authenticate();

            if (empty($id)) {
                Template::set_message(lang('contact_invalid_id'), 'danger');
                redirect('contacts');
            }

            if($id = $this->contact_model->find_by('slug_contact',$id)->id_contact){

            $contact = $this->contact_model->find_user_and_meta($id);

            if($contact->deleted){

              Template::set_message(lang('contact_is_deleted'), 'danger');
              Template::redirect('contacts');

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
            Template::set('users_access', $this->db->join("users","users.id = contacts_users.user_id","left")->where("contacts_users.contact_id",$data['id_contact'])->get("contacts_users"));
            Template::set('contact', $contact);
            Template::set('toolbar_title', $contact->display_name);
            Template::render();

          }else{

            Template::set_message(lang('contact_invalid_id'), 'danger');
            redirect('contact');
          }

      }


      public function complete_geo($idc){

        $this->authenticate();

        if (isset($_POST['save'])) {

          $meta_data_lat = array(
            'meta_key'=>'lat',
            'meta_value'=>$this->input->post('lat'),
            'contact_id'=>$idc
          );

          $this->db->insert('contact_meta',$meta_data_lat);

          $meta_data_lng = array(
            'meta_key'=>'lng',
            'meta_value'=>$this->input->post('lng'),
            'contact_id'=>$idc
          );

          $this->db->insert('contact_meta',$meta_data_lng);

          Template::set_message(lang('contact_customer_geo_success'), 'success');
          Template::redirect('home');

        }

        $data_html = array('html'=>'');
        Events::trigger('show_geo_complete',$data_html);
        Template::set('data_html',$data_html['html']);

        Template::set('meta',$this->contact_model->find_meta_for($idc,array('country','city','adress')));
        Template::set('toolbar_title', lang('contact_customer_check_position'));
        Template::render();

      }

    }
