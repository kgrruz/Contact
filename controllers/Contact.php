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
                redirect('home');
            }

            if($id = $this->contact_model->find_by('slug_contact',$id)->id_contact){

            $contact = $this->contact_model->find_user_and_meta($id);

            if($contact->deleted){

              Template::set_message(lang('contact_is_deleted'), 'danger');
              Template::redirect('home');

            }


            Template::set('tabs',array());
            Template::set('contact_type',array());
            Template::set('users_access', $this->db->join("users","users.id = contacts_users.user_id","left")->where("contacts_users.contact_id",$id)->get("contacts_users"));
            Template::set('contact', $contact);
            Template::set('toolbar_title', $contact->display_name);
            Template::render();

          }else{

            Template::set_message(lang('contact_invalid_id'), 'danger');
            redirect('home');
          }

      }


      public function complete_geo($idc){

        $this->authenticate();

        if (empty($idc)) {
            Template::set_message(lang('contact_invalid_id'), 'danger');
            Template::redirect($this->agent->referrer());
        }

        if($idc = $this->contact_model->find_by('slug_contact',$idc)->id_contact){

        if (isset($_POST['save'])) {

          $this->form_validation->set_rules('lat', 'lang:contact_card_locale', 'required');

          if($this->form_validation->run()){

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

          if($current_user->role_id == 2){

                  Template::redirect('home');

          }else{

                  Template::redirect('admin/content/map');

          }

        }else{

          Template::set_message(validation_errors(),'danger');
          Template::redirect($this->agent->referrer());

        }
      }

        $data_html = array('html'=>'');
        Events::trigger('show_geo_complete',$data_html);
        Template::set('data_html',$data_html['html']);

        Template::set('meta',$this->contact_model->find_meta_for($idc,array('country','city','adress')));
        Template::set('toolbar_title', lang('contact_customer_check_position'));
        Template::render();

      }else{

          Template::set_message(lang('contact_invalid_id'), 'danger');
          Template::redirect($this->agent->referrer());

      }
    }
  }
