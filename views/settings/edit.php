<?php

if (validation_errors()) :
?>
<div class='alert alert-block alert-error fade in'>
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
<div class='admin-box'>
    <h3>Contact</h3>
    <?php echo form_open($this->uri->uri_string(), 'class="form-horizontal"'); ?>
        <fieldset>
            

            <div class="control-group<?php echo form_error('display_name') ? ' error' : ''; ?>">
                <?php echo form_label(lang('contact_field_display_name') . lang('bf_form_label_required'), 'display_name', array('class' => 'control-label')); ?>
                <div class='controls'>
                    <input id='display_name' type='text' required='required' name='display_name' maxlength='255' value="<?php echo set_value('display_name', isset($contact->display_name) ? $contact->display_name : ''); ?>" />
                    <span class='help-inline'><?php echo form_error('display_name'); ?></span>
                </div>
            </div>

            <div class="control-group<?php echo form_error('email1') ? ' error' : ''; ?>">
                <?php echo form_label(lang('contact_field_email1') . lang('bf_form_label_required'), 'email1', array('class' => 'control-label')); ?>
                <div class='controls'>
                    <input id='email1' type='text' required='required' name='email1' maxlength='255' value="<?php echo set_value('email1', isset($contact->email1) ? $contact->email1 : ''); ?>" />
                    <span class='help-inline'><?php echo form_error('email1'); ?></span>
                </div>
            </div>

            <div class="control-group<?php echo form_error('birthday') ? ' error' : ''; ?>">
                <?php echo form_label(lang('contact_field_birthday') . lang('bf_form_label_required'), 'birthday', array('class' => 'control-label')); ?>
                <div class='controls'>
                    <input id='birthday' type='text' required='required' name='birthday' maxlength='10' value="<?php echo set_value('birthday', isset($contact->birthday) ? $contact->birthday : ''); ?>" />
                    <span class='help-inline'><?php echo form_error('birthday'); ?></span>
                </div>
            </div>

            <div class="control-group<?php echo form_error('timezone') ? ' error' : ''; ?>">
                <?php echo form_label(lang('contact_field_timezone') . lang('bf_form_label_required'), 'timezone', array('class' => 'control-label')); ?>
                <div class='controls'>
                    <input id='timezone' type='text' required='required' name='timezone' maxlength='10' value="<?php echo set_value('timezone', isset($contact->timezone) ? $contact->timezone : ''); ?>" />
                    <span class='help-inline'><?php echo form_error('timezone'); ?></span>
                </div>
            </div>
        </fieldset>
        <fieldset class='form-actions'>
            <input type='submit' name='save' class='btn btn-primary' value="<?php echo lang('contact_action_edit'); ?>" />
            <?php echo lang('bf_or'); ?>
            <?php echo anchor(SITE_AREA . '/settings/contact', lang('contact_cancel'), 'class="btn btn-warning"'); ?>
            
            <?php if ($this->auth->has_permission('Contact.Settings.Delete')) : ?>
                <?php echo lang('bf_or'); ?>
                <button type='submit' name='delete' formnovalidate class='btn btn-danger' id='delete-me' onclick="return confirm('<?php e(js_escape(lang('contact_delete_confirm'))); ?>');">
                    <span class='icon-trash icon-white'></span>&nbsp;<?php echo lang('contact_delete_record'); ?>
                </button>
            <?php endif; ?>
        </fieldset>
    <?php echo form_close(); ?>
</div>