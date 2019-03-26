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

        $this->customer = $this->user_model->find_contact_user($this->auth->user_id());

      }

    

      public function complete_geo(){

        $this->authenticate();

        Assets::add_module_css('contact','ol.css');
        Assets::add_module_js('contact','ol.js');

        Assets::add_module_css('contact','ol-geocoder.min.css');
        Assets::add_module_js('contact','ol-geocoder.js');

        Assets::add_module_js('contact','map_widget.js');

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
