<div class="card"><?php if($data){ ?>

  <nav class="navbar navbar-expand-lg navbar-light bg-light">

  <div class="collapse navbar-collapse" id="navbarNavAltMarkup">
    <div class="navbar-nav">
      <a class="nav-item nav-link btn btn-success btn-sm text-white" href="<?php echo base_url(); ?>add_contato/1/<?php echo $contact->id_contact; ?>"><?php echo lang('contact_action_create'); ?></a>
  </div>
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
          </tr>
      </thead>
      <tbody>
  <?php foreach($data as $contato){ ?>

        <tr>
              <td><?php echo ($contato->contact_type == 1)? '<i class="fa fa-user" aria-hidden="true"></i>':'<i class="fa fa-building" aria-hidden="true"></i>'; ?></td>
              <td><?php echo anchor('contato/'.$contato->slug_contact,$contato->display_name); ?></td>
              <td><?php echo mailto($contato->email); ?></td>
              <td><?php echo $contato->phone; ?></td>
              <td><?php echo $contato->cargo; ?></td>
              <td>
                <div class="btn-group btn-group-sm" role="group" >

                  <?php echo anchor('admin/content/contact/edit/'.$contato->slug_contact,'<i class="fa fa-edit" aria-hidden="true"></i>
            ','class="btn btn-sm btn-secondary"'); ?>
            <?php echo anchor('admin/content/contact/delete/'.$contato->id_contact,'<i class="fa fa-trash" aria-hidden="true"></i>','data-message="'.lang("contact_delete_confirm").'" class="btn btn-light exc_bot" '); ?>

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

  <h4 class="card-title"><?php echo lang('contact_records_empty'); ?></h4>
    <p class="card-text"><?php echo lang('contact_no_records'); ?></p>
    <?php echo anchor('add_contato/1/'.$id_contact,lang('contact_action_create'),'class="btn btn-sm btn-primary"'); ?>

</div>
<?php } ?></div>
