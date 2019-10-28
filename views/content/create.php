<div class="card">
  <?php
$defaultTimezone = isset($user->timezone) ? $user->timezone : strtoupper(settings_item('site.default_user_timezone'));
$defaultCountry = settings_item('contact.default_country');
$defaultState   = settings_item('contact.default_state');

?>
<?php echo form_open($this->uri->uri_string(),'id="form_contact"'); ?>
<div class="card-body">

    <?php if (validation_errors()) : ?>

<div class='alert alert-block alert-danger'>
    <a class='close' data-dismiss='alert'>&times;</a>
    <h4 class='alert-heading'>
        <?php echo lang('contact_errors_message'); ?>
    </h4>
    <?php echo validation_errors(); ?>
</div>
<?php
endif;

$id = isset($contact->id_contact) ? $contact->id_contact : '';

?>
<div class="row">
  <div class="col-md-6">

    <div class="row">
            <div class="col-sm-6 form-group<?php echo form_error('display_name') ? ' error' : ''; ?>">
                <?php echo form_label(lang('contact_field_display_name') . lang('bf_form_label_required'), 'display_name', array('class' => 'control-label')); ?>

                    <input id='display_name' type='text' class="form-control  " required='required' name='display_name' maxlength='255' value="<?php echo set_value('display_name', isset($contact->display_name) ? $contact->display_name : ''); ?>" />
                    <span class='help-inline'><?php echo form_error('display_name'); ?></span>

            </div>

  <?php if($contact_type == 2){ ?>
  </div>
<div class="row">
    <div class="col-sm-6 form-group<?php echo form_error('fantasy_name') ? ' error' : ''; ?>">
        <?php echo form_label(lang('contact_field_fantasy_name') , 'fantasy_name', array('class' => 'control-label')); ?>

            <input id='fantasy_name' type='text' class="form-control  "  name='fantasy_name' maxlength='255' value="<?php echo set_value('fantasy_name', isset($contact->fantasy_name) ? $contact->fantasy_name : ''); ?>" />
            <span class='help-inline'><?php echo form_error('fantasy_name'); ?></span>

    </div>

    <div class="col-sm-6 form-group<?php echo form_error('cnpj') ? ' error' : ''; ?>">
        <?php echo form_label(lang('contact_field_cnpj'), 'cnpj', array('class' => 'control-label')); ?>

            <input id='cnpj' type='text' class="form-control  cnpj" name='cnpj' maxlength='255' value="<?php echo set_value('cnpj', isset($contact->cnpj) ? $contact->cnpj : ''); ?>" />
            <span class='help-inline'><?php echo form_error('cnpj'); ?></span>

    </div>
    </div>
    <div class="row">

  <?php }else{ ?>


        <div class="col-sm-6 form-group<?php echo form_error('cpf') ? ' error' : ''; ?>">
            <?php echo form_label(lang('contact_field_cpf'), 'cpf', array('class' => 'control-label')); ?>

                <input id='cpf' type='text' class="form-control cpf" name='cpf' maxlength='15' value="<?php echo set_value('cnpj', isset($contact->cpf) ? $contact->cpf : ''); ?>" />
                <span class='help-inline'><?php echo form_error('cpf'); ?></span>

        </div>

      <?php } ?>
</div>

<div class="row">
            <div class="col-sm-6 form-group<?php echo form_error('phone') ? ' error' : ''; ?>">
                <?php echo form_label(lang('contact_field_phone'), 'phone', array('class' => 'control-label')); ?>

                    <input type='text' class="form-control phone"  id="phone" name='phone'  value="<?php echo set_value('phone', isset($contact->phone) ? $contact->phone : ''); ?>" />
                    <span class='help-inline'><?php echo form_error('phone'); ?></span>

            </div>
            <div class="col-sm-6 form-group<?php echo form_error('phone2') ? ' error' : ''; ?>">
                <?php echo form_label(lang('contact_field_phone'), 'phone2', array('class' => 'control-label')); ?>

                    <input type='text' class="form-control phone"  id="phone2" name='phone2'  value="<?php echo set_value('phone2', isset($contact->phone2) ? $contact->phone2 : ''); ?>" />
                    <span class='help-inline'><?php echo form_error('phone2'); ?></span>

            </div>
            </div>

<div class="row">

            <div class="col-sm-6 form-group<?php echo form_error('email') ? ' error' : ''; ?>">
                <?php echo form_label(lang('contact_field_email'), 'email', array('class' => 'control-label')); ?>

                    <input type='email' class="form-control  "  id="email" name='email'  value="<?php echo set_value('email', isset($contact->email) ? $contact->email : ''); ?>" />
                    <span class='help-inline'><?php echo form_error('email'); ?></span>

            </div>



            <div class="col-sm-6 form-group<?php echo form_error('group') ? ' error' : ''; ?>">
                <?php echo form_label(lang('contact_field_groups') . lang('bf_form_label_required'), 'group', array('class' => 'control-label')); ?>

                    <select id='group' class="form-control  form-control  form-control -sm-sm" multiple name='group[]' >
                       <?php if(count($tree['items'])){ foreach($tree['items'] as $group){ ?>
                      <option <?php if(isset($my_groups)){ if(in_array($group['id_group'],$my_groups)){ echo 'selected'; }}else if($group['id_group'] == 1){ echo 'selected'; } ?> value="<?php echo $group['id_group']; ?>"><?php echo str_repeat('-', $this->nested_set->getNodeLevel($group)*4); ?> <?php echo ucfirst($group['group_name']); ?></option>
                    <?php } }else{ ?><option value="0"><?php echo lang('group_no_records'); ?></option><?php } ?>
                    </select>
                    <span class='help-inline'><?php echo form_error('group'); ?></span>

            </div>
            </div>

            <?php echo $data_html; ?>


              <?php if($contact_type == 1){ ?>

            <div class="form-group<?php echo form_error('company') ? ' error' : ''; ?>">
                <?php echo form_label(lang('contact_field_company') , 'contact', array('class' => 'control-label')); ?>

            <select class="form-control"  id="company" name="company">
              <option value="0"><?php echo lang('contact_select_company'); ?></option>
              <?php if($companies){ foreach($companies as $comp){ ?>
              <option value="<?php echo $comp->id_contact; ?>" <?php echo (isset($selected_company) and $selected_company == $comp->id_contact)? 'selected':''; ?> ><?php echo $comp->display_name; ?></option>
            <?php } }?>
            </select>
            <span class='help-inline'><?php echo form_error('company'); ?></span>

            </div>

            <div class="form-group<?php echo form_error('job_role') ? ' error' : ''; ?>">
                <?php echo form_label(lang('contact_field_job_role') , 'job_role', array('class' => 'control-label')); ?>

            <select class="form-control  tokenize" id="job_role" data-placeholder="<?php echo lang('contact_select_job_role'); ?>" name="job_role"  value="<?php echo set_value('job_role', isset($contact->job_role) ? $contact->job_role : ''); ?>">
              <option></option>
              <?php foreach($job_roles->result() as $role){ ?>
                <option value="<?php echo $role->meta_value; ?>" <?php echo (isset($contact) and $contact->job_role == $role->meta_value)? 'selected':''; ?> ><?php echo $role->meta_value; ?></option>
                <?php } ?>
            </select>
            <span class='help-inline'><small><?php echo lang('help_tab_tokenize'); ?></small> <?php echo form_error('job_role'); ?></span>

            </div>

          <?php } ?>

            </div>

            <div class="col-md-6">

<?php if(!isset($data_html_adress)){ ?>

  <div class="form-group<?php echo form_error('timezone') ? ' error' : ''; ?>">
  <label class="control-label required" for="timezones"><?php echo lang('bf_timezone'); ?></label>

      <?php
      echo timezone_menu(
          set_value('timezones', isset($contact->timezone) ? $contact->timezone : $defaultTimezone),
          'form-control',
          'timezone',
          array('id' => 'timezone')
      );
      ?>
      <span class="help-inline"><?php echo form_error('timezones'); ?></span>
  </div>

<div class="row">

  <div class="col-sm-6 form-group<?php echo form_error('country') ? ' error' : ''; ?>">
  <label class="control-label required" for="country"><?php echo lang('contact_field_country'); ?></label>

  <?php
  $countryValue =  isset($contact->country) ? $contact->country : $defaultCountry;
  echo country_select(
      set_value('country',$countryValue),
      $defaultCountry,
      'country',
      'form-control  chzn-select'
  );
  ?>
      <span class="help-inline"><?php echo form_error('country'); ?></span>
  </div>

  <div class="col-sm-6 form-group<?php echo form_error('state') ? ' error' : ''; ?>">
  <label class="control-label required" for="state"><?php echo lang('contact_field_state'); ?></label>

  <?php
  $stateValue =  isset($contact->state) ? $contact->state : $defaultState;
  echo state_select(
      set_value('state', $stateValue),
      $defaultState,
      $defaultCountry,
      'state',
      'form-control  chzn-select'
  );
  ?>
      <span class="help-inline"><?php echo form_error('state'); ?></span>
  </div>
  </div>

              <div class="form-group<?php echo form_error('postcode') ? ' error' : ''; ?>">
                <?php echo form_label(lang('contact_field_postcode'), 'postcode', array('class' => 'control-label')); ?>
                      <input id='postcode' type='text'  class="form-control ad postcode"  placeholder="<?php echo lang('contact_field_postcode'); ?>" name='postcode' maxlength='20' value="<?php echo set_value('postcode', isset($contact->postcode) ? $contact->postcode : ''); ?>" />
                      <span class='help-inline'><?php echo form_error('postcode'); ?></span>
              </div>

<div class="row">

              <?php if(isset($selected_company)){
                $city_company = $this->contact_model->find_meta_for($selected_company,array('city'))->city;
              }else{ $city_company = ''; }  ?>
              <div class="col-sm-6 form-group<?php echo form_error('city') ? ' error' : ''; ?>">

                <?php echo form_label(lang('contact_field_city') . lang('bf_form_label_required'), 'city', array('class' => 'control-label')); ?>
                      <select id='city' type='text'  class="form-control ad"  data-placeholder="<?php echo lang('contact_field_city'); ?>" name='city' />
                        <option></option>
                        <?php foreach($cities->result() as $city){ ?>
                          <option value="<?php echo $city->meta_value; ?>" <?php if(isset($contact)){ echo ($contact->city == $city->meta_value)? 'selected':''; }else{ echo ($city_company == $city->meta_value)? 'selected':''; } ?>  ><?php echo $city->meta_value; ?></option>
                          <?php } ?>
                        </select>
                        <span class='help-inline'><small><?php echo lang('help_tab_tokenize'); ?></small>
                      <span class='help-inline'><?php echo form_error('city'); ?></span>
              </div>


              <div class="col-sm-6 form-group<?php echo form_error('neibor') ? ' error' : ''; ?>">
                  <?php echo form_label(lang('contact_field_neibor') , 'neibor', array('class' => 'control-label')); ?>
                      <input id='neibor' type='text'  class="form-control  ad"  name='neibor' maxlength='40' placeholder="<?php echo lang('contact_field_neibor'); ?>" value="<?php echo set_value('neibor', isset($contact->neibor) ? $contact->neibor : ''); ?>" />
                      <span class='help-inline'><?php echo form_error('neibor'); ?></span>
              </div>
              </div>
<div class="row">
              <div class="col-sm-9 form-group<?php echo form_error('adress') ? ' error' : ''; ?>">
                  <?php echo form_label(lang('contact_field_adress'), 'adress', array('class' => 'control-label')); ?>
                      <input id='adress' type='text'  class="form-control  ad"  name='adress' maxlength='80' placeholder="<?php echo lang('contact_field_adress'); ?>" value="<?php echo set_value('adress', isset($contact->adress) ? $contact->adress : ''); ?>" />
                      <span class='help-inline'><?php echo form_error('adress'); ?></span>
              </div>

              <div class="col-sm-3 form-group<?php echo form_error('num_adress') ? ' error' : ''; ?>">
                <?php echo form_label(lang('contact_field_num_adress'), 'num_adress', array('class' => 'control-label')); ?>
                      <input id='num_adress' type='text' class="form-control  ad"   name='num_adress' placeholder="<?php echo lang('contact_field_num_adress'); ?>" maxlength='20' value="<?php echo set_value('num_adress', isset($contact->num_adress) ? $contact->num_adress : ''); ?>" />
                      <span class='help-inline'><?php echo form_error('num_adress'); ?></span>
              </div>
              </div>

<input type="hidden" name="contact_type" value="<?php echo $contact_type; ?>" />

<?php echo form_input(array('name'=>'save','type'=>'hidden','value'=>lang('contact_action_create'))); ?>
<?php } ?>
            </div>
            </div>
            </div>


<div class="card-footer">
                <button type='submit' id="create_contact" class='btn btn-sm btn-primary'><?php echo lang('contact_action_create'); ?></button>
                <?php echo lang('bf_or'); ?>
                <?php echo anchor('admin/content/contact', lang('contact_cancel'), 'class="btn btn-sm btn-warning"'); ?>
</div>
<?php echo form_close(); ?>

  <?php   Assets::add_js(
              $this->load->view(
                  'users/country_state_js',
                  array(
                      'country_name'  => 'country',
                      'country_value' => $countryValue,
                      'state_name'    => 'state',
                      'state_value'   => $stateValue,
                  ),
                  true
              ),
              'inline'
          ); ?>
</div>
