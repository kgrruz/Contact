
<div class="row">

    <div class="col-md-4">

  <div class="card mb-3">
    <div class="row no-gutters">

      <div class="col-md-12">

        <div class="card-body">

          <div class="media">
    <?php echo contact_avatar($contact->email, 64,'img-fluid mr-3',true,'profile_photo');  ?>
  <div class="media-body">
    <h5 class="mt-0"><?php echo ($contact->contact_type == 1)? '<i class="fa fa-user" aria-hidden="true"></i>':'<i class="fa fa-building" aria-hidden="true"></i>'; ?>
      <?php echo (isset($contact->is_user))? '<i class="fa fa-key"></i>':''; ?> <?php echo $contact->display_name; ?>

    </h5>
    <?php echo anchor('admin/content/contact/delete/'.$contact->id_contact,'<i class="fa fa-trash" aria-hidden="true"></i>','data-message="'.lang("contact_delete_confirm").'" class="btn btn-sm btn-light exc_bot" '); ?>
    <?php echo anchor('admin/content/contact/edit/'.$contact->slug_contact,'<i class="fa fa-edit" aria-hidden="true"></i>','class="btn btn-sm btn-secondary"'); ?>


<?php echo (!empty($contact->job_role))? '<span class="badge badge-success">'.$contact->job_role.'</span>':''; ?>
  </div>
</div>
        </div>

            <?php if(isset($contact->country)){ ?>
        <ul class="list-group">
  <li class="list-group-item">  <i class="fa fa-map-marker" aria-hidden="true"></i>
<?php echo (isset($contact->city))? $contact->city:lang("contact_city_indef"); ?>,  <?php echo (isset($contact->state))? $contact->state:''; ?> <?php //echo anchor("contact/complete_geo/".$contact->slug_contact,lang("contact_set_coordinate")); ?></li>
  <li class="list-group-item"> <?php echo (isset($contact->neibor) and !empty($contact->neibor))? $contact->neibor:lang('contact_miss_info'); ?></li>
  <li class="list-group-item"> <?php echo (isset($contact->adress) and !empty($contact->adress))? $contact->adress:lang('contact_miss_info'); ?>
    <?php echo (isset($contact->num_adress) and !empty($contact->num_adress))? '-'.$contact->num_adress:lang('contact_miss_info'); ?></li>
  <?php if(!empty($contact->cnpj) or !empty($contact->cpf)){ ?>
    <li class="list-group-item"> <?php echo (isset($contact->cnpj))? $contact->cnpj:''; ?> <?php echo (isset($contact->cpf))? $contact->cpf:''; ?></li>
<?php } ?>
  <?php if(!empty($contact->email)){ ?> <li class="list-group-item"> <?php echo mailto($contact->email); ?></li><?php } ?>
  <?php echo (!empty($contact->phone))? '<li class="list-group-item">'.$contact->phone.'</li>':''; ?>
  <?php echo (!empty($contact->phone_2))? '<li class="list-group-item">'.$contact->phone_2.'</li>':''; ?>


  <?php if(isset($contact->company) and $contact->company != 0){ ?>
  <?php $company = $this->contact_model->find($contact->company);  ?>
  <li class="list-group-item"><?php echo anchor('contato/'.$company->slug_contact,'<i class="fa fa-building" aria-hidden="true"></i> '.$company->display_name); ?></li>
<?php } ?>
</ul>
      <?php } ?>
      </div>
    </div>
  </div>

  <?php echo $data_html; ?>

<?php if($filiais->num_rows()){ ?>
  <div class="card mt-3">
  <div class="card-header">Filiais</div>
          <div class="table-responsive">
          <table class="table">
  <?php foreach($filiais->result() as $fili){ ?>
<tr>
  <td><?php echo anchor('contato/'.$fili->slug_contact,ellipsize($fili->display_name,50)); ?></td>
  <td> <?php echo $fili->phone; ?></td>
</tr>
  <?php } ?>
</table>
  </div>
  </div>
<?php } ?>

<?php if(isset($contact->matriz) and $contact->matriz){ ?>
  <div class="card mt-3">
  <div class="card-header">Matriz</div>
          <div class="table-responsive">
          <table class="table">
            <?php $matriz = $this->contact_model->find($contact->matriz); ?>
<tr>
  <td><?php echo anchor('contato/'.$matriz->slug_contact,ellipsize($matriz->display_name,50)); ?></td>
  <td> <?php echo $matriz->phone; ?></td>
</tr>
</table>
  </div>
  </div>
<?php } ?>

  </div>
<div class="col-md-8">


    <ul class="nav nav-tabs">

        <?php if(count($tabs)){ ?>

          <?php foreach($tabs as $tab){ ?>
            <?php if(isset($tab['contact_type']) and in_array($contact->contact_type,$tab['contact_type']) or !isset($tab['contact_type'])){ ?>

              <li class="nav-item">
                <a href="<?php echo base_url().'contato/'.$contact->slug_contact.'/'.$tab['url']; ?>" class="nav-link <?php echo ($function_tab == $tab['url'])? 'active':''; ?> ">
                   <?php echo $tab['label'][$current_user->language]; ?>
                 </a>
               </li>

          <?php } ?>
        <?php } ?>
        <?php } ?>

        </ul>


        <?php if(is_array($contact_type) and !in_array($contact->contact_type,$contact_type)){ ?>
        <div class="card">
      <div class="card-body text-center">
          <h4 class="card-title"><?php echo lang('contact_nothing_show_title'); ?></h4>
            <p class="card-text"><?php echo lang('contact_nothing_show_desc'); ?></p>

          </div>
        </div>
        <?php }else{  $this->load->view($view_page); } ?>




  </div>
</div>


<script> var contact_id = <?php echo $contact->id_contact; ?>; </script>
