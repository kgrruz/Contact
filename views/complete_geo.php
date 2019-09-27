<div class="card">
<div class="card-header">Mapa</div>

<?php echo form_open($this->uri->uri_string()); ?>

<input type="hidden" id="adress" value="<?php echo (isset($meta->adress))? $meta->adress:''; ?>" />
<input type="hidden" id="city" value="<?php echo (isset($meta->city))? $meta->city:''; ?>" />
<input type="hidden" id="country" value="<?php echo (isset($meta->city))? $meta->country:''; ?>" />
<input type="hidden" id="neibor" value="" />

<?php echo $data_html; ?>
<div class="card-footer">

<input type="submit" name="save" value="<?php echo lang('contact_customer_save_coordinate'); ?>" class="btn btn-success" />

<?php echo form_close(); ?>

</div>
</div>
