<?php
$defaultTimezone = strtoupper(settings_item('site.default_user_timezone'));
$defaultCountry = settings_item('contact.default_country');
$defaultState   = settings_item('contact.default_state');
?>

<?php echo form_open($this->uri->uri_string()); ?>

<div class="card mb-3">
    <div class="card-header"><?php echo lang('contact_settings_default_locale'); ?></div>
    <div class="card-body">

<div class="row">

<div class="col-sm-6 form-group<?php echo form_error('country') ? ' error' : ''; ?>">
<label class="control-label required" for="country"><?php echo lang('contact_field_country'); ?></label>

<?php
$countryValue =  isset($defaultCountry) ? $defaultCountry : 'BR';
echo $countryValue;
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
