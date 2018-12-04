
<?php if($contatos){  ?>

  <nav class="navbar navbar-expand-lg navbar-light bg-light">
  <div class="collapse navbar-collapse" id="navbarSupportedContent">

    <form action="<?php echo base_url(); ?>contact/index" method="get" class="form-inline my-2 my-lg-0">

      <select class="form-control mr-sm-2" name="city">
        <option value="0"><?php echo lang('contact_field_city'); ?></option>
        <?php foreach($cities->result() as $city){ ?>
          <option value="<?php echo $city->meta_value; ?>" <?php echo (isset($_GET['city']) and $_GET['city'] == $city->meta_value)? 'selected':''; ?> ><?php echo $city->meta_value; ?></option>
          <?php } ?>
      </select>

      <select class="form-control mr-sm-2" name="contact_type">
        <option value="0"><?php echo lang('contact_all_types'); ?></option>
        <option value="1" <?php echo (isset($_GET['contact_type']) and $_GET['contact_type'] == 1)? 'selected':''; ?> ><?php echo lang('contact_contact'); ?></option>
        <option value="2" <?php echo (isset($_GET['contact_type']) and $_GET['contact_type'] == 2)? 'selected':''; ?> ><?php echo lang('contact_company'); ?></option>
      </select>

      <input class="form-control mr-sm-2" type="search"  value="<?php echo (isset($_GET['term']) and !empty($_GET['term']))? $_GET['term']:''; ?>" name="term" placeholder="<?php echo lang('bf_search'); ?>" aria-label="<?php echo lang('bf_search'); ?>">
      <button class="btn btn-success my-2 my-sm-0" type="submit"><?php echo lang('bf_search'); ?></button>
    </form>
  </div>
</nav>

<div class="table-responsive">

<table id="table_contacts" class="table table-hover table-outline table-vcenter text-nowrap mb-0" >
    <thead>
        <tr>
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
            <td><?php echo ($contato->contact_type == 1)? '<i class="fa fa-user" aria-hidden="true"></i>':'<i class="fa fa-building" aria-hidden="true"></i>'; ?> <?php echo ($contato->is_user)? '<i class="fa fa-key"></i>':''; ?></td>
            <td><?php echo anchor('contato/'.$contato->slug_contact,$contato->display_name); ?></td>
            <td><?php echo mailto($contato->email); ?></td>
            <td><?php echo $contato->phone; ?></td>
            <td><?php echo $contato->city; ?></td>
            <td><?php echo date('d/m/Y H:i',strtotime($contato->created_on)); ?></td>

            <td>
              <div class="btn-group btn-group-sm" role="group" >

                <?php echo anchor('contact/edit/'.$contato->slug_contact,'<i class="fa fa-edit" aria-hidden="true"></i>
          ','class="btn btn-sm btn-secondary"'); ?>
          <?php echo anchor('contact/delete/'.$contato->id_contact,'<i class="fa fa-trash" aria-hidden="true"></i>','data-message="'.lang("contact_delete_confirm").'" class="btn btn-light exc_bot" '); ?>

              </div>
            </td>
      </tr>
<?php } ?>
    </tbody>
</table>




</div>

  <?php if($pags = $this->pagination->create_links()){ ?>
<div class="card-footer">
<?php echo $pags; ?>
</div>
<?php } } else{ ?>
  <div class="card-body text-center">

  <h4 class="card-title">Sem registros</h4>
    <p class="card-text">Não há contatos registrados.</p>
    <?php echo anchor('contact/create',lang('contact_action_create'),'class="btn btn-sm btn-primary"'); ?>

</div>
  <?php } ?>
