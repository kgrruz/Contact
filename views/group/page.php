




<div class="card-body">
	<h4><?php echo $group->group_name; ?></h4>
	<div class="card-text"><?php echo $group->description; ?></div>
</div>

<?php if($contacts){ ?>

<div class="table-responsive ">
<table id="table_contacts" class="table table-sm nowrap" cellspacing="0" width="100%">
<thead>
		<tr>

			<th></th>
			<th><?php echo lang('contact_column_display_name'); ?></th>
			<th><?php echo lang('contact_column_email'); ?></th>
			<th><?php echo lang('contact_column_phone'); ?></th>
			<th></th>
			<th><?php echo lang('contact_column_created'); ?></th>
			<th></th>
		</tr>
</thead>
<tbody>
	<?php foreach($contacts as $contato){ ?>

	<tr>

		<td class="pl-3"><?php echo ($contato->contact_type == 1)? '<i class="fa fa-user" aria-hidden="true"></i>':'<i class="fa fa-building" aria-hidden="true"></i>'; ?> <?php echo ($contato->is_user)? '<i class="fa fa-key"></i>':''; ?></td>

	  <td><?php echo anchor('contato/'.$contato->slug_contact,$contato->display_name); ?></td>
	  <td><?php echo mailto($contato->email); ?></td>
	  <td><?php echo $contato->phone; ?></td>
	  <td><?php echo $contato->city; ?></td>
	  <td><?php echo ut_date($contato->created_on,$current_user->d_format.' '.$current_user->t_format); ?></td>

	  <td>
	    <div class="btn-group btn-group-sm" role="group" >

	      <?php echo anchor('contact/edit/'.$contato->slug_contact,'<i class="fa fa-edit" aria-hidden="true"></i>
	','class="btn btn-sm btn-secondary"'); ?>

	    </div>
	  </td>
	</tr>
	<?php } ?>




</tbody>
</table>
</div>

<?php }else{ ?>
<div class="card-body">
	<?php echo lang('group_zero_contacts_ingroup'); ?>
</div>
<?php } ?>
