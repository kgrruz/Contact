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
        $this->load->model('roles/role_model');

        $this->siteSettings = $this->settings_lib->find_all();

        Template::set_block('sub_nav', 'contact/settings/_sub_nav');
    }

    public function index(){


      if (isset($_POST['save'])) {

          $this->form_validation->set_rules('key_map', 'lang:contact_key_map', 'required|trim|max_length[120]');
          $this->form_validation->set_rules('email_require', 'lang:contact_email_require', 'required');


          if ($this->form_validation->run() === false) {
              Template::set_message(lang('contact_settings_save_error'), 'error');
          } else {

              $data = array(
                  array('name' => 'contact.api_key_maps', 'value' => $this->input->post('key_map')),
                  array('name' => 'contact.email_require',     'value' => $this->input->post('email_require'))
                  );

              // Save the settings to the db
              $updated = $this->settings_model->update_batch($data, 'name');
              if ($updated) {
                  // Success, reload the page so they can see their settings
                  Template::set_message(lang('contact_settings_save_success'), 'success');
                  redirect(SITE_AREA . '/settings/emailer');
              }

              Template::set_message(lang('contact_settings_save_error'), 'error');
          }
      }

      Template::set('toolbar_title', lang('us_user_management'));
      Template::render();

    }
  }
