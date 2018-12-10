<div class="form-group<?php echo form_error('contact') ? ' error' : ''; ?>">
    <?php echo form_label($label . lang('bf_form_label_required'), 'contact', array('class' => 'control-label')); ?>

<select class="form-control form-control-sm" id="contact_id" name="contact_id" >
  <option value="0"><?php echo lang('contact_select_contact'); ?></option>
  <?php foreach($contacts as $contact){ ?>
  <option value="<?php echo $contact->id_contact; ?>" data-contact="<?php echo $contact->display_name; ?>"  data-img="<?php echo contact_avatar($contact->email, 20,null, false,'thumb'); ?>" <?php echo (isset($contact_id) and $contact_id == $contact->id_contact)? 'selected':''; ?> >
     <?php echo $contact->display_name; ?>
   </option>
<?php } ?>
</select>

</div>
