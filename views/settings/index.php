<?php
$defaultTimezone = settings_item('contact.default_timezone');
$defaultCountry  = settings_item('contact.default_country');
$defaultState    = settings_item('contact.default_state');
?>

<?php echo form_open($this->uri->uri_string()); ?>

<div class="card mb-3">
    <div class="card-header"><?php echo lang('contact_settings_default_locale'); ?></div>
    <div class="card-body">

<div class="row">

  <div class="col-sm-4">
    <div class="form-group<?php echo form_error('timezone') ? ' error' : ''; ?>">
  <label class="control-label required" for="timezone"><?php echo lang('bf_timezone'); ?></label>

  <?php
  $timezoneValue =  isset($defaultTimezone) ? $defaultTimezone : 'UM3';
  echo timezone_menu(
      set_value('timezones', $timezoneValue),
      'form-control',
      'timezone',
      array('id' => 'timezone')
  );
  ?>
      <span class="help-inline"><?php echo form_error('timezone'); ?></span>
  </div>
    <div class="form-group<?php echo form_error('display_timezone_select') ? ' error' : ''; ?> form-check">
    <input type="checkbox" name="display_timezone_select" <?php echo (settings_item('contact.display_timezone_select'))? 'checked':''; ?> class="form-check-input" id="display_timezone_select">
    <label class="form-check-label" for="display_timezone_select"><?php echo lang('contact_settings_show_options'); ?></label>
  </div>

  </div>


<div class="col-sm-4">
  <div class="form-group<?php echo form_error('country') ? ' error' : ''; ?>">
<label class="control-label required" for="country"><?php echo lang('contact_field_country'); ?></label>

<?php
$countryValue =  isset($defaultCountry) ? $defaultCountry : 'BR';
echo country_select(
    set_value('country',$countryValue),
    $defaultCountry,
    'country',
    'form-control  chzn-select'
);
?>
    <span class="help-inline"><?php echo form_error('country'); ?></span>
</div>

  <div class="form-group<?php echo form_error('display_country_select') ? ' error' : ''; ?> form-check">
  <input type="checkbox" name="display_country_select" <?php echo (settings_item('contact.display_country_select'))? 'checked':''; ?>  class="form-check-input" id="display_country_select">
  <label class="form-check-label" for="display_country_select"><?php echo lang('contact_settings_show_options'); ?></label>
</div>

</div>

<div class="col-sm-4">
  <div class="form-group<?php echo form_error('state') ? ' error' : ''; ?>">
<label class="control-label required" for="state"><?php echo lang('contact_field_state'); ?></label>

<?php
$stateValue =  isset($defaultState) ? $defaultState: '';
echo state_select(
    set_value('state', $stateValue),
    $defaultState,
    $countryValue,
    'state',
    'form-control chzn-select'
);
?>
    <span class="help-inline"><?php echo form_error('state'); ?></span>
</div>

<div class="form-group<?php echo form_error('display_state_select') ? ' error' : ''; ?> form-check">
<input type="checkbox" name="display_state_select" <?php echo (settings_item('contact.display_state_select'))? 'checked':''; ?>  class="form-check-input" id="display_state_select">
<label class="form-check-label" for="display_state_select"><?php echo lang('contact_settings_show_options'); ?></label>
</div>

</div>
</div>
</div>

<div class="card-footer">
  <input type="submit" name="save" class="btn btn-sm btn-primary" value="<?php e(lang('contact_save_settings')); ?>" />
</div>
</div>
</form>

<?php Assets::add_js(
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
        );  ?>
