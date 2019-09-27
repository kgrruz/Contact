
<?php if($users_access->num_rows()){ ?>

<div class="card mb-3">
  <div class="card-header"><i class="fa fa-key"></i>&nbsp;<?php echo lang('contact_access_by'); ?></div>
      <ul class="list-group list-group-flush">
        <div class="row">
        <?php foreach($users_access->result() as $us){ ?>
          <div class="col-md-6">
          <li class="list-group-item">
            <div class="media">
              <?php echo user_avatar($us->photo_avatar,$us->email, 60,'d-flex mr-3', true,'thumbs'); ?>
              <div class="media-body row">
                <div class="col-md-9">
                <h5 class="mt-0"><?php echo anchor($us->username,ellipsize($us->display_name,30)); ?></h5>
              <span class="badge badge-success" ><?php echo role_user_by_id($us->role_id); ?></span>
              </div>
                      <div class="col-md-3 my-auto">
                        <?php echo anchor("contact/content/remove_access/".$us->id_access_key,'<i class="fa fa-trash"></i>','data-message="'.lang("contact_confirm_remove_access").'" class="btn btn-light exc_bot" '); ?>
            </div>
            </div>
            </div>
          </li>  </div>
        <?php } ?>
        </div>
      </ul>
  </div>

<?php } ?>


<?php if($this->auth->has_permission('Contact.Content.Create')){ ?>

  <div class="card">
  <div class="card-header">
    <?php echo lang('contact_give_access'); ?>
 </div>
<?php $errorClass = 'error';
$controlClass = 'form-control form-control-sm';
$fieldData = array(
    'errorClass'    => $errorClass,
    'controlClass'  => $controlClass,
);


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

if (isset($user) && $user->banned) :
?>
<div class="alert alert-danger">
    <h4 class="alert-heading"><?php echo lang('us_banned_admin_note'); ?></h4>
</div>
<?php
endif;

if (isset($password_hints)) :
?>
<div class="alert alert-info">
    <a data-dismiss="alert" class="close">&times;</a>
    <?php echo $password_hints; ?>
</div>
<?php
endif;

$meta = $this->contact_model->find_meta_for($contact->id_contact,array('is_user'));

 if ($this->settings_lib->item('contact.allow_user_invite') == 1){ ?>

   <?php  if(!property_exists($meta, 'is_user')){ ?>
     <div class="card-body">
       <?php
echo form_open('admin/content/contact/send_access', array('class' => 'form-horizontal', 'autocomplete' => 'off'));
?>

<div class="row">
  <div class="col-md-7">

<input type="hidden" name="contact_invite" value="<?php echo $contact->id_contact; ?>" />

  <div class="form-group row">
  <label for="role_id" class="col-sm-4 col-form-label" ><?php echo lang('bf_user'); ?></label>
  <div class="col-sm-8">
  <select  name="user" id="user_access" class="form-control form-control-sm" >
    <?php foreach($data as $user){ ?>
    <option value="<?php echo $user->id; ?>"  data-email="<?php echo $user->email; ?>" data-contact="<?php echo $user->display_name; ?>"  data-img="<?php echo user_avatar($user->photo_avatar,$user->email,50,'rounded mr-2',false,'thumbs'); ?>" > <?php echo $user->display_name; ?> </option>
  <?php } ?>
</select>
</div>
</div>


        <?php
        // Allow modules to render custom fields.
        Events::trigger('render_invite_form', $renderPayload);
        ?>
      </div>
      </div>
      </div>

    <div class="card-footer">
        <input type="submit" name="save" class="btn btn-sm btn-primary" value="<?php echo lang('contact_action_give_access') . ' ' . lang('bf_user'); ?>" />
    </div>

<?php echo form_close(); ?>


<?php }else{ ?><div class="card-body"><?php echo (property_exists($meta, 'is_user') )? lang('us_already_register'):lang('us_not_email'); ?></div><?php }
}else{ ?><div class="card-body"><?php echo lang('us_not_allowed_invites'); ?></div><?php } ?>  </div><?php } ?>


  <?php $this->load->view('content/create_user'); ?>
