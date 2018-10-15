<h3 class="my-3"><?php echo lang('contact_customer_check_position'); ?></h3>

<?php echo form_open('contact/customer/complete_geo'); ?>

<input type="hidden" id="adress" value="<?php echo (isset($meta->adress))? $meta->adress:''; ?>" />
<input type="hidden" id="city" value="<?php echo $meta->city; ?>" />
<input type="hidden" id="country" value="<?php echo $meta->country; ?>" />
<input type="hidden" id="neibor" value="" />

<?php echo $data_html; ?>

<hr>

<input type="submit" name="save" value="<?php echo lang('contact_customer_save_coordinate'); ?>" class="btn btn-success" />

<?php echo form_close(); ?>
