<div class="card-body">

<h2 class="Subhead-heading"><?php echo $toolbar_title; ?></h2>
    <p class="Subhead-description">
      <?php echo lang('contact_desc_form_create'); ?>
    </p>

  <?php echo form_open($this->uri->uri_string(),'id="form_contact"'); ?>

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

$id = isset($laudo_rad->id) ? $laudo_rad->id : '';

?>
<div class="row">
  <div class="col-md-4">
            <div class="form-group<?php echo form_error('display_name') ? ' error' : ''; ?>">
                <?php echo form_label(lang('contact_field_display_name') . lang('bf_form_label_required'), 'display_name', array('class' => 'control-label')); ?>

                    <input id='display_name' type='text' class="form-control form-control-sm " required='required' name='display_name' maxlength='255' value="<?php echo set_value('display_name', isset($contact->display_name) ? $contact->display_name : ''); ?>" />
                    <span class='help-inline'><?php echo form_error('display_name'); ?></span>

            </div>

  <?php if($contact_type == 2){ ?>

    <div class="form-group<?php echo form_error('fantasy_name') ? ' error' : ''; ?>">
        <?php echo form_label(lang('contact_field_fantasy_name') , 'fantasy_name', array('class' => 'control-label')); ?>

            <input id='fantasy_name' type='text' class="form-control form-control-sm "  name='fantasy_name' maxlength='255' value="<?php echo set_value('fantasy_name', isset($contact->fantasy_name) ? $contact->fantasy_name : ''); ?>" />
            <span class='help-inline'><?php echo form_error('fantasy_name'); ?></span>

    </div>

    <div class="form-group<?php echo form_error('cnpj') ? ' error' : ''; ?>">
        <?php echo form_label(lang('contact_field_cnpj'), 'cnpj', array('class' => 'control-label')); ?>

            <input id='cnpj' type='text' class="form-control form-control-sm cnpj" name='cnpj' maxlength='255' value="<?php echo set_value('cnpj', isset($contact->cnpj) ? $contact->cnpj : ''); ?>" />
            <span class='help-inline'><?php echo form_error('cnpj'); ?></span>

    </div>

  <?php }else{ ?>


        <div class="form-group<?php echo form_error('cpf') ? ' error' : ''; ?>">
            <?php echo form_label(lang('contact_field_cpf'), 'cpf', array('class' => 'control-label')); ?>

                <input id='cpf' type='text' class="form-control form-control-sm cpf" name='cpf' maxlength='15' value="<?php echo set_value('cnpj', isset($contact->cpf) ? $contact->cpf : ''); ?>" />
                <span class='help-inline'><?php echo form_error('cpf'); ?></span>

        </div>

      <?php } ?>

            <div class="form-group<?php echo form_error('phone') ? ' error' : ''; ?>">
                <?php echo form_label(lang('contact_field_phone'), 'phone', array('class' => 'control-label')); ?>

                    <input type='text' class="form-control form-control-sm "  id="phone" name='phone'  value="<?php echo set_value('phone', isset($contact->phone) ? $contact->phone : ''); ?>" />
                    <span class='help-inline'><?php echo form_error('phone'); ?></span>

            </div>


            <div class="form-group<?php echo form_error('email') ? ' error' : ''; ?>">
                <?php echo form_label(lang('contact_field_email'), 'email', array('class' => 'control-label')); ?>

                    <input type='email' class="form-control form-control-sm "  id="email" name='email'  value="<?php echo set_value('email', isset($contact->email) ? $contact->email : ''); ?>" />
                    <span class='help-inline'><?php echo form_error('email'); ?></span>

            </div>



            <div class="form-group<?php echo form_error('group') ? ' error' : ''; ?>">
                <?php echo form_label(lang('contact_field_groups') . lang('bf_form_label_required'), 'group', array('class' => 'control-label')); ?>

                    <select id='group' class="form-control form-control-sm form-control form-control-sm-sm" multiple name='group[]' >
                      <?php foreach($tree['items'] as $group){ ?>
                      <option <?php if(isset($my_groups)){ if(in_array($group['id_group'],$my_groups)){ echo 'selected'; }}elseif($group['id_group'] == 1){ echo 'selected';} ?> value="<?php echo $group['id_group']; ?>"><?php echo str_repeat('-', $this->nested_set->getNodeLevel($group)*4); ?> <?php echo ucfirst($group['group_name']); ?></option>
                    <?php } ?>
                    </select>
                    <span class='help-inline'><?php echo form_error('group'); ?></span>

            </div>

            <?php echo $data_html; ?>


              <?php if($contact_type == 1){ ?>

            <div class="form-group<?php echo form_error('company') ? ' error' : ''; ?>">
                <?php echo form_label(lang('contact_field_company') , 'contact', array('class' => 'control-label')); ?>

            <select class="form-control form-control-sm tokenize" multiple id="company" name="company">
              <option value="0"><?php echo lang('contact_select_company'); ?></option>
              <?php foreach($companies as $contact){ ?>
              <option value="<?php echo $contact->id_contact; ?>" <?php echo (isset($selected_company) and $selected_company == $contact->id_contact)? 'selected':''; ?> ><?php echo $contact->display_name; ?></option>
            <?php } ?>
            </select>
            <span class='help-inline'><?php echo form_error('company'); ?></span>

            </div>

            <div class="form-group<?php echo form_error('job_role') ? ' error' : ''; ?>">
                <?php echo form_label(lang('contact_field_job_role') , 'job_role', array('class' => 'control-label')); ?>

            <select class="form-control form-control-sm tk_job_role" id="job_role" multiple data-placeholder="<?php echo lang('contact_select_job_role'); ?>" name="job_role"  value="<?php echo set_value('job_role', isset($contact->job_role) ? $contact->job_role : ''); ?>">
            </select>
            <span class='help-inline'><?php echo form_error('job_role'); ?></span>

            </div>

          <?php } ?>

            </div>

            <div class="col-md-4">

<?php if(!isset($data_html_adress)){ ?>

  <input type="hidden" id="country" name="country" value="Brasil" />
  <input type="hidden" id="state" name="state" value="MG" />
  <input type="hidden" id="timezone" name="timezone" value="UM3" />

              <div class="form-group<?php echo form_error('postcode') ? ' error' : ''; ?>">
                <?php echo form_label(lang('contact_field_postcode'), 'postcode', array('class' => 'control-label')); ?>
                      <input id='postcode' type='text'  class="form-control form-control-sm ad postcode"  placeholder="<?php echo lang('contact_field_postcode'); ?>" name='postcode' maxlength='20' value="<?php echo set_value('postcode', isset($contact->postcode) ? $contact->postcode : ''); ?>" />
                      <span class='help-inline'><?php echo form_error('postcode'); ?></span>
              </div>
              <div class="form-group<?php echo form_error('city') ? ' error' : ''; ?>">
                <?php echo form_label(lang('contact_field_city') . lang('bf_form_label_required'), 'city', array('class' => 'control-label')); ?>
                      <input id='city' type='text'  class="form-control form-control-sm ad"  placeholder="<?php echo lang('contact_field_city'); ?>" name='city' maxlength='20' value="<?php echo set_value('city', isset($contact->city) ? $contact->city : ''); ?>" />
                      <span class='help-inline'><?php echo form_error('city'); ?></span>
              </div>

              <div class="form-group<?php echo form_error('neibor') ? ' error' : ''; ?>">
                  <?php echo form_label(lang('contact_field_neibor') , 'neibor', array('class' => 'control-label')); ?>
                      <input id='neibor' type='text'  class="form-control form-control-sm ad"  name='neibor' maxlength='40' placeholder="<?php echo lang('contact_field_neibor'); ?>" value="<?php echo set_value('neibor', isset($contact->neibor) ? $contact->neibor : ''); ?>" />
                      <span class='help-inline'><?php echo form_error('neibor'); ?></span>
              </div>

              <div class="form-group<?php echo form_error('adress') ? ' error' : ''; ?>">
                  <?php echo form_label(lang('contact_field_adress'), 'adress', array('class' => 'control-label')); ?>
                      <input id='adress' type='text'  class="form-control form-control-sm ad"  name='adress' maxlength='80' placeholder="<?php echo lang('contact_field_adress'); ?>" value="<?php echo set_value('adress', isset($contact->adress) ? $contact->adress : ''); ?>" />
                      <span class='help-inline'><?php echo form_error('adress'); ?></span>
              </div>

              <div class="form-group<?php echo form_error('num_adress') ? ' error' : ''; ?>">
                <?php echo form_label(lang('contact_field_num_adress'), 'num_adress', array('class' => 'control-label')); ?>
                      <input id='num_adress' type='text' class="form-control form-control-sm ad"   name='num_adress' placeholder="<?php echo lang('contact_field_num_adress'); ?>" maxlength='20' value="<?php echo set_value('num_adress', isset($contact->num_adress) ? $contact->num_adress : ''); ?>" />
                      <span class='help-inline'><?php echo form_error('num_adress'); ?></span>
              </div>

<input type="hidden" name="contact_type" value="<?php echo $contact_type; ?>" />

<?php echo form_input(array('name'=>'save','type'=>'hidden','value'=>lang('contact_action_create'))); ?>
<?php } ?>
            </div>
            </div>
            </div>


<div class="card-footer">
                <input type='submit' value="<?php echo lang('contact_action_create'); ?>" class='btn btn-sm btn-primary' />
                <?php echo lang('bf_or'); ?>
                <?php echo anchor('contacts', lang('contact_cancel'), 'class="btn btn-sm btn-warning"'); ?>
</div>

  <?php echo form_close(); ?>
