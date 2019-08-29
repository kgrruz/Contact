<div class="form-group<?php echo form_error('contact') ? ' error' : ''; ?>">
    <?php echo form_label($label . lang('bf_form_label_required'), 'contact', array('class' => 'control-label')); ?>

<select class="form-control form-control-sm" data-placeholder="<?php echo lang("contact_placeholder"); ?>" id="contact_id" name="contact_id" >
  <?php if($contact){ ?>
  <option selected value="<?php echo $contact->id_contact; ?>"><?php echo $contact->display_name; ?></option>
  <?php }else{ ?>
  <option><?php echo lang("contact_placeholder"); ?></option>
  <?php } ?>
</select>

</div>
