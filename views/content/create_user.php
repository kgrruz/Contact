<?php if($this->auth->has_permission('Contact.Content.Create')){

  $errorClass     = empty($errorClass) ? ' error' : $errorClass;
  $controlClass   = empty($controlClass) ? 'form-control form-control-sm' : $controlClass;
  $registerClass  = ' required';
  $editSettings   = 'edit';
  $password       = $this->auth->generateStrongPassword();
  $username       = $this->auth->generate_unique_username($contact->display_name);

  ?>

  <div class="card mt-3">
     <div class="card-header">
       <?php echo lang('us_create_user'); ?>
     </div>

<?php

if (isset($password_hints)) {
    $fieldData['password_hints'] = $password_hints;
}

// For the settings form, $renderPayload should not be set to $current_user or
// $this->auth->user(), as it can't be assumed that $current_user is the same as
// the user being edited.
$renderPayload = null;
if (isset($current_user)) {
    $fieldData['current_user'] = $current_user;
}
if (isset($user)) {
    $fieldData['user'] = $user;
    $renderPayload = $user;
}

if (validation_errors()) :
?>
<div class='alert alert-danger'>
    <?php echo validation_errors(); ?>
</div>
<?php
endif;

$meta = $this->contact_model->find_meta_for($contact->id_contact,array('is_user'));

 if ($this->settings_lib->item('contact.allow_user_invite') == 1){ ?>

   <?php  if(!property_exists($meta, 'is_user')){ ?>
     <div class="card-body">
       <?php
echo form_open('admin/content/users/create', array('class' => 'form-horizontal', 'autocomplete' => 'off'));
?>

<div class="row">
  <div class="col-md-7">

<input type="hidden" name="contact_invite" value="<?php echo $contact->id_contact; ?>" />

<div class="form-group<?php echo form_error('display_name') ? $errorClass : ''; ?>">
<label class="control-label" for="display_name"><?php echo lang('bf_display_name'); ?></label>
<div class="controls">
<input class="<?php echo $controlClass; ?>" type="text" id="display_name" name="display_name" value="<?php echo set_value('display_name', $contact->display_name ); ?>" />
<span class="help-inline"><?php echo form_error('display_name'); ?></span>
</div>
</div>


<div class="form-group row<?php echo form_error('email') ? $errorClass : ''; ?>">
<div class="col-sm-6">
    <label class="control-label required" for="email"><?php echo lang('bf_email'); ?></label>
    <div class="controls">
        <input class="<?php echo $controlClass; ?>" type="email" id="email" name="email" value="<?php echo set_value('email', $contact->email ); ?>" />
        <span class="help-inline"><?php echo form_error('email'); ?></span>
    </div>
</div>
<?php if(!isset($user)){ ?>
<div class="col-sm-6">
    <label class="control-label required" for="email_confirm"><?php echo lang('bf_email_confirm'); ?></label>
    <div class="controls">
        <input class="<?php echo $controlClass; ?>" type="email" id="email_confirm" name="email_confirm" value="<?php echo set_value('email_confirm'); ?>" />
        <span class="help-inline"><?php echo form_error('email_confirm'); ?></span>
    </div>
</div>

<?php } ?>
</div>

<?php if (settings_item('auth.login_type') !== 'email' || settings_item('auth.use_usernames')) : ?>
<div class="form-group row<?php echo form_error('username') ? $errorClass : ''; ?>">
<div class="col-sm-6">
<label class="control-label required" for="username"><?php echo lang('bf_username'); ?></label>
<div class="controls">
    <input class="<?php echo $controlClass; ?> " type="text" id="username" name="username" value="<?php echo $username; ?>" />
    <span class="help-inline"><?php echo form_error('username'); ?></span>
</div>
</div>
</div>
<?php endif; ?>

<div class="form-group row<?php echo form_error('password') ? $errorClass : ''; ?>">
<div class="col-md-6">
<div class="controls">
    <input autocomplete="off" data-toggle="popover" data-trigger="focus" title="<?php echo lang('bf_password'); ?>" data-placement="left" data-html="true" data-content="<?php echo isset($password_hints) ? $password_hints : ''; ?>" class="<?php echo $controlClass; ?>" type="hidden" id="password" name="password" value="<?php echo $password; ?>" />
    <span class="help-inline"><?php echo form_error('password'); ?></span>

</div>
</div>
<div class="col-md-6">
<div class="controls">
    <input autocomplete="off" class="<?php echo $controlClass; ?>" type="hidden" id="pass_confirm" name="pass_confirm" value="<?php echo $password; ?>" />
    <span class="help-inline"><?php echo form_error('pass_confirm'); ?></span>
</div>
</div>
</div>

<input type="hidden" value="2" name="role_id" />
<input type="hidden" value="<?php echo $contact->id_contact; ?>" name="contact_id" />
<input type="hidden" value="portuguese_br" name="language" />
<input type="hidden" value="UM3" name="timezone" />
<input type="hidden" value="<?php echo $contact->country; ?>" name="country" />
<input type="hidden" value="<?php echo $contact->state; ?>" name="state" />


        <?php
        // Allow modules to render custom fields.
        Events::trigger('render_invite_form', $renderPayload);
        ?>
      </div>
      </div>

      <div class="alert alert-info">
        <?php echo lang('us_password_auto_generate'); ?>
      </div>

      </div>

    <div class="card-footer">
        <input type="submit" name="save" class="btn btn-sm btn-primary" value="<?php echo lang('bf_action_save') . ' ' . lang('bf_user'); ?>" />
    </div>
<?php
echo form_close();

}else{ ?><div class="card-body"><?php echo (property_exists($meta, 'is_user') )? lang('us_already_register'):lang('us_not_email'); ?></div><?php }
}else{ ?><div class="card-body"><?php echo lang('us_not_allowed_invites'); ?></div><?php } ?></div>
<?php } ?>
