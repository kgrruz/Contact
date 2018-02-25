<div class="card">
    <div class="card-header"><?php echo lang('contact_general_settings'); ?></div>
    <div class="card-body">
      <div class="col-md-7">
    <div class="form-group row<?php echo form_error('key_map') ? ' error' : ''; ?>">
        <label class="col-sm-4 col-form-label" for="key_map"><?php echo lang('contact_key_map'); ?></label>
<div class="col-sm-8">
            <input type="text" name="key_map" id="key_map" class="form-control form-control-sm" value="<?php echo set_value('key_map', $this->settings_lib->item('contact.api_key_maps')); ?>" />
            <span class='help-inline'><?php echo form_error('key_map'); ?></span>
    </div>
    </div>

    <div class="form-group row<?php echo form_error('email_require') ? ' error' : ''; ?>">
        <label class="col-sm-4 col-form-label" for="email_require"><?php echo lang('contact_email_require'); ?></label>
<div class="col-sm-8">
            <select name="email_require" class="form-control form-control-sm" id="email_require">
                <option value='0'><?php echo lang('bf_no'); ?></option>
                <option selected value='1' ><?php echo lang('bf_yes'); ?></option>
            </select>
            <span class="help-inline"><?php echo form_error('email_require'); ?></span>

    </div>    </div>
</div>
</div>
<div class="card-footer">
  <input type="submit" name="save" class="btn btn-sm btn-primary" value="<?php e(lang('contact_save_settings')); ?>" />
</div>
</div>
