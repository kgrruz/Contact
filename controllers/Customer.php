<?php defined('BASEPATH') || exit('No direct script access allowed');

/**
 * Customer controller
 */
class Customer extends Front_Controller{

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

        $this->lang->load('contact/contact');
        $this->load->model('users/user_model');
        $this->load->model('contact/contact_model');
        $this->load->library('users/auth');

        $this->customer = $this->user_model->find_contact_user($this->auth->user_id());

      }

      public function _redirect_complete_geo($data){

        $meta_loc = $this->contact_model->find_meta_for($this->customer,array('lat','lng'));

        if($data['role_id'] == 4 and !$meta_loc->lng){ Template::redirect('contact/customer/complete_geo'); }

      }

      public function complete_geo(){

        $this->authenticate();

        if (isset($_POST['save'])) {

          $meta_data_lat = array(
            'meta_key'=>'lat',
            'meta_value'=>$this->input->post('lat'),
            'contact_id'=>$this->customer
          );

          $this->db->insert('contact_meta',$meta_data_lat);

          $meta_data_lng = array(
            'meta_key'=>'lng',
            'meta_value'=>$this->input->post('lng'),
            'contact_id'=>$this->customer
          );

          $this->db->insert('contact_meta',$meta_data_lng);

          Template::set_message(lang('contact_customer_geo_success'), 'success');
          Template::redirect('home');

        }

        $data_html = array('html'=>'');
        Events::trigger('show_geo_complete',$data_html);
        Template::set('data_html',$data_html['html']);

        Template::set('meta',$this->contact_model->find_meta_for($this->customer,array('country','city','adress')));
        Template::set('toolbar_title', lang('contact_customer_check_position'));
        Template::render();

      }

    }
