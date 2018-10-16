
<?php if($contatos){ ?>

  <nav class="navbar navbar-expand-lg navbar-light bg-light">

  <div class="collapse navbar-collapse" id="navbarSupportedContent">

  <form action="<?php echo uri_string(); ?>" method="get" class="form-inline my-2 my-lg-0">

      <select class="form-control mr-sm-2" name="city">
        <option value="0"><?php echo lang('contact_field_city'); ?></option>
        <?php foreach($cities->result() as $city){ ?>
          <option value="<?php echo $city->meta_value; ?>"><?php echo $city->meta_value; ?></option>
          <?php } ?>
      </select>

      <select class="form-control mr-sm-2" name="contact_type">
        <option value="0"><?php echo lang('contact_all_types'); ?></option>
        <option value="1"><?php echo lang('contact_contact'); ?></option>
        <option value="2"><?php echo lang('contact_company'); ?></option>
      </select>

      <input class="form-control mr-sm-2" type="search" value="<?php echo set_value('term'); ?>" name="term" placeholder="<?php echo lang('bf_search'); ?>" aria-label="<?php echo lang('bf_search'); ?>">
      <button class="btn btn-success my-2 my-sm-0" type="submit"><?php echo lang('bf_search'); ?></button>
    </form>
  </div>
</nav>

<div class="table-responsive ">

  <?php echo form_open(); ?>
<table id="table_contacts" class="table table-sm nowrap border-0" cellspacing="0" width="100%">
    <thead>
        <tr>
            <th class="pl-3"><input class="check-all" type="checkbox" /></th>
            <th></th>
            <th><?php echo lang('contact_column_display_name'); ?></th>
            <th><?php echo lang('contact_column_email'); ?></th>
            <th><?php echo lang('contact_column_phone'); ?></th>

            <th></th>
            <th></th>
            <th></th>
        </tr>
    </thead>
    <tbody>
<?php foreach($contatos as $contato){ ?>

      <tr>
            <td class="pl-3"><input type="checkbox" name="checked[]" value="<?php echo $contato->id_contact; ?>" /></td>
            <td><?php echo ($contato->contact_type == 1)? '<i class="fa fa-user-circle-o" aria-hidden="true"></i>':'<i class="fa fa-building" aria-hidden="true"></i>'; ?> <?php echo ($contato->is_user)? '<i class="fa fa-key"></i>':''; ?></td>
            <td><?php echo anchor('contato/'.$contato->slug_contact,$contato->display_name); ?></td>
            <td><?php echo mailto($contato->email); ?></td>
            <td><?php echo $contato->phone; ?></td>
            <td><?php echo $contato->city; ?></td>
            <td><?php echo date('d/m/Y H:i',strtotime($contato->created_on)); ?></td>

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
      <td colspan="7"><?php
      echo lang('bf_with_selected'); ?>

      <input type="submit" name="delete" class="btn  btn-sm btn-danger" id="delete-me" value="<?php echo lang('bf_action_delete'); ?>" onclick="return confirm('<?php e(js_escape(lang('contact_delete_account_confirm'))); ?>')" />
</td>
</tr>
</tfoot>
</table>




</div>

  <?php if($pags = $this->pagination->create_links()){ ?>
<div class="card-footer">
<?php echo $pags; ?>
</div>
<?php } ?>

<?php echo form_close(); ?>

<?php } else{ ?>
  <div class="card-body text-center">

  <h4 class="card-title">Sem registros</h4>
    <p class="card-text">Não há contatos registrados.</p>
    <?php echo anchor('contact/create',lang('contact_action_create'),'class="btn btn-sm btn-primary"'); ?>

</div>
  <?php } ?>
