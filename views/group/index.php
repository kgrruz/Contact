
<?php if(count($tree['items'])){ ?>
      <div class="table-responsive ">
          <?php echo form_open(); ?>
        <table id="table_groups" class="table table-hover table-outline table-vcenter text-nowrap mb-0" >

    <thead>
        <tr>

          <th class="pl-3" ><input class="check-all" type="checkbox" /></th>
            <th></th>
            <th></th>
            <th><?php echo lang('group_field_description'); ?></th>
            <th  class="text-center" ><?php echo lang('group_field_number_contacts'); ?></th>
            <th><?php echo lang('group_field_created_on'); ?></th>
            <th></th>
        </tr>
    </thead>
    <tbody>
<?php  foreach($tree['items'] as $group){ ?>
<tr>
    <td class="pl-3"><?php if($group['id_group'] != 1){ ?>
    <input type="checkbox" name="checked[]" value="<?php echo $group['id_group']; ?>" />
  <?php } ?>
 </td>
  <td><i class="fa fa-folder"></i></td>
  <td>
<?php echo str_repeat('&nbsp;', $this->nested_set->getNodeLevel($group)*4); ?>
    <?php echo anchor('contact/group/page/'.$group['slug_group'],ucfirst($group['group_name'])); ?></td>
  <td><?php echo ellipsize($group['description'],60); ?></td>
  <td class="text-center"><span class="badge badge-pill badge-primary"><?php echo $this->group_model->count_contacts_in_group($group['id_group']); ?></span></td>
  <td><?php echo ut_date($group['created_on'],$current_user->d_format); ?></td>
  <td>
    <?php if($group['id_group'] != 1){ ?>
    <?php echo anchor('contact/group/edit/'.$group['slug_group'],'<i class="fa fa-edit" aria-hidden="true"></i>
','class="btn btn-sm btn-secondary"'); ?>  <?php } ?></td>
</tr>
<?php } ?>
    </tbody>
</table>


</div>
<div class="card-footer">
  <?php
  echo lang('bf_with_selected'); ?>

  <input type="submit" name="delete" class="btn btn-sm btn-danger" id="delete-me" value="<?php echo lang('bf_action_delete'); ?>" onclick="return confirm('<?php e(js_escape(lang('group_delete_confirm'))); ?>')" />

</div>
<?php echo form_close(); ?>
<?php } else{ ?>
  <div class="card-body">
  <div class="card-text">
<?php echo lang('group_no_records'); ?>
</div>
</div>
<?php } ?>
