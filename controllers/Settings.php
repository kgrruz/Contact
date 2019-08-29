<?php defined('BASEPATH') || exit('No direct script access allowed');
/**
 * Bonfire
 *
 * An open source project to allow developers to jumpstart their development of
 * CodeIgniter applications.
 *
 * @package   Bonfire
 * @author    Bonfire Dev Team
 * @copyright Copyright (c) 2011 - 2014, Bonfire Dev Team
 * @license   http://opensource.org/licenses/MIT
 * @link      http://cibonfire.com
 * @since     Version 1.0
 * @filesource
 */

/**
 * Contacts Settings Controller.
 *
 * Manages the contact functionality on the admin pages.
 *
 * @package    Bonfire\Modules\Contacts\Controllers\Settings
 * @author     Bonfire Dev Team
 * @link       http://cibonfire.com/docs/developer/roles_and_permissions
 *
 */
class Settings extends Admin_Controller{

    private $siteSettings;
    private $permissionCreate = 'Contact.Settings.Create';
    private $permissionManage = 'Contact.Settings.Manage';
    private $permissionView   = 'Contact.Settings.View';

    /**
     * Setup the required permissions.
     *
     * @return void
     */
    public function __construct(){

        parent::__construct();

        $this->auth->restrict($this->permissionView);

        $this->lang->load('contact/contact');

        $this->siteSettings = $this->settings_lib->find_all();

        Template::set_block('sub_nav', 'contact/settings/_sub_nav');
    }

    public function index(){


      if (isset($_POST['save'])) {

          $this->form_validation->set_rules('state', 'lang:contact_settings_default_state', 'required|trim');
          $this->form_validation->set_rules('country', 'lang:contact_settings_default_country', 'required|trim');


          if ($this->form_validation->run() === false) {
              Template::set_message(lang('contact_settings_save_error'), 'danger');
          } else {

              $data = array(
                  array('name' => 'contact.default_state', 'value' => $this->input->post('state')),
                  array('name' => 'contact.default_country',     'value' => $this->input->post('country'))
                  );

              // Save the settings to the db
              $updated = $this->settings_model->update_batch($data, 'name');
              if ($updated) {
                  // Success, reload the page so they can see their settings
                  Template::set_message(lang('contact_settings_save_success'), 'success');
                  redirect(SITE_AREA . '/settings/contact');
              }

              Template::set_message(lang('contact_settings_save_error'), 'danger');
          }
      }

      $this->load->config('address');
      $this->load->helper('address');

      Template::set('toolbar_title', lang('contact_settings'));
      Template::render();

    }
  }
