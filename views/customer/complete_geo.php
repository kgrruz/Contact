<h3 class="my-3"><?php echo lang('contact_customer_check_position'); ?></h3>

<?php echo form_open('contact/customer/complete_geo'); ?>

<input type="hidden" id="adress" value="<?php echo (isset($meta->adress))? $meta->adress:''; ?>" />
<input type="hidden" id="city" value="<?php echo (isset($meta->city))? $meta->city:''; ?>" />
<input type="hidden" id="country" value="<?php echo $meta->country; ?>" />
<input type="hidden" id="neibor" value="" />

<div class="card">
<div class="card-header">Mapa</div>
<div id="map"></div>
</div>

<div id="click_address"></div>

<input type="hidden" name="lat" id="lat" />
<input type="hidden" name="lng" id="lng" />

<hr>

<input type="submit" name="save" value="<?php echo lang('contact_customer_save_coordinate'); ?>" class="btn btn-success" />

<?php echo form_close(); ?>
