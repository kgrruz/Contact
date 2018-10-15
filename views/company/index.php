<nav class="navbar navbar-expand-lg navbar-light bg-light">

  <div class="collapse navbar-collapse" id="navbarNavAltMarkup">
    <div class="navbar-nav">
      <a class="nav-item nav-link btn btn-success btn-sm text-white" href="<?php echo base_url(); ?>contact/create/1/<?php echo $contact->id_contact; ?>"><?php echo lang('contact_action_create'); ?></a>
  </div>
  </div>
</nav>
<?php  if($data){ ?>


  <?php echo form_open(); ?>
<div class="table-responsive">
<table id="table_contacts" class="table table-sm nowrap" cellspacing="0" width="100%">
    <thead>
        <tr>
            <th class="pl-3"><input class="check-all" type="checkbox" /></th>
            <th></th>
            <th><?php echo lang('contact_column_display_name'); ?></th>
            <th><?php echo lang('contact_column_email'); ?></th>
            <th><?php echo lang('contact_column_phone'); ?></th>
            <th><?php echo lang('contact_column_job_role'); ?></th>

            <th></th>
        </tr>
    </thead>
    <tbody>
<?php foreach($data as $contato){ ?>

      <tr>
            <td class="pl-3"><input type="checkbox" name="checked[]" value="<?php echo $contato->id_contact; ?>" /></td>
            <td><i class="fa fa-user-circle-o" aria-hidden="true"></i></td>
            <td><?php echo anchor('contato/'.$contato->slug_contact,$contato->display_name); ?></td>
            <td><?php echo mailto($contato->email); ?></td>
            <td><?php echo $contato->phone; ?></td>
            <td><?php echo $contato->cargo; ?></td>

            <td>
              <div class="btn-group btn-group-sm" role="group" >

                <?php echo anchor('contact/edit/'.$contato->slug_contact,'<i class="fa fa-pencil-square-o" aria-hidden="true"></i>
          ','class="btn btn-sm btn-secondary"'); ?>

              </div>
            </td>
      </tr>
    <?php } ?>
    </tbody>
    <tfoot>
      <tr><td></td>
      <td colspan="6"><?php
      echo lang('bf_with_selected'); ?>

      <input type="submit" name="delete" class="btn  btn-sm btn-danger" id="delete-me" value="<?php echo lang('bf_action_delete'); ?>" onclick="return confirm('<?php e(js_escape(lang('contact_delete_account_confirm'))); ?>')" />
</td>
</tr>
</tfoot>
</table>

</div>
</div>

<?php if($pags = $this->pagination->create_links()){ ?>
<div class="card-footer">
<?php echo $pags; ?>
</div>
<?php } ?>


<?php echo form_close(); ?>

<?php } else{ ?>
  <div class="card-body text-center">

  <h4 class="card-title"><?php echo lang('contact_records_empty'); ?></h4>
    <p class="card-text"><?php echo lang('contact_no_records'); ?></p>
    <?php echo anchor('contact/create/1/'.$id_contact,lang('contact_action_create'),'class="btn btn-sm btn-primary"'); ?>

</div>
  <?php } ?>

</div>
