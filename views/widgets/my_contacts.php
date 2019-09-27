<div class="card mb-3">
  <div class="card-header">Minhas contas</div>

<?php if($contacts){ ?>

  <ul class="list-group list-group-flush">

  <?php foreach($contacts as $contact){ ?>

    <li class="list-group-item d-flex justify-content-between align-items-center" >



    <a href="<?php echo base_url(); ?>contato/<?php echo $contact->slug_contact; ?>">    <?php echo ($contact->contact_type == 1)? '<i class="fa fa-user" aria-hidden="true"></i>':'<i class="fa fa-building" aria-hidden="true"></i>'; ?> <?php echo $contact->display_name; ?></a>

    <?php echo (!$this->contact_model->find_meta_for($contact->id_contact,array('lat','lng'))->lng)? anchor('contact/complete_geo/'.$contact->slug_contact,'<i class="fa fa-map-marker"></i> '.lang('contact_set_coordinate')):'&nbsp;'; ?>

      <span class="badge badge-primary badge-pill"><?php echo relative_time($contact->created_on); ?></span>

    </li>

<?php } ?>

</ul>

<?php } else{ ?> <div class="card-body"> Não encontramos contas registradas.</div><?php } ?>


</div>
