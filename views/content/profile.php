
<div class="row">
  <div class="col-md-3">

    <div class="card">

        <?php echo contact_avatar($contact->email, 224,'card-img-top img-fluid w-100',true,'profile_photo');  ?>

  <div class="card-body">
    <h4 class="card-title"><?php echo ($contact->contact_type == 1)? '<i class="fa fa-user" aria-hidden="true"></i>':'<i class="fa fa-building" aria-hidden="true"></i>'; ?> <?php echo (isset($contact->is_user))? '<i class="fa fa-key"></i>':''; ?> <?php echo $contact->display_name; ?> </h4>
    <?php echo anchor('contact/edit/'.$contact->slug_contact,'<i class="fa fa-edit" aria-hidden="true"></i> '.lang('contact_action_edit')); ?>
      <?php echo (!empty($contact->job_role))? '<p class="card-text">'.$contact->job_role.'</p>':''; ?>
    <p class="card-text"><?php echo mailto($contact->email); ?></p>
  </div>
  <ul class="list-group list-group-flush">

    	<?php if(isset($contact->country)){ ?>
				<li class="list-group-item">
				<i class="fa fa-map-marker" aria-hidden="true"></i>
	 <?php echo (isset($contact->city))? $contact->city:lang("contact_city_indef"); ?>,  <?php echo (isset($contact->state))? $contact->state:''; ?><br/>
	 <?php echo (isset($contact->neibor) and !empty($contact->neibor))? $contact->neibor.'<br/>':''; ?>
	 <?php echo (isset($contact->adress) and !empty($contact->adress))? $contact->adress:''; ?><?php echo (isset($contact->num_adress) and !empty($contact->num_adress))? '-'.$contact->num_adress:''; ?>
	  </li>
	<?php } ?>

    <?php echo (!empty($contact->phone))? '<li class="list-group-item">'.$contact->phone.'</li>':''; ?>
    <?php echo (!empty($contact->phone_2))? '<li class="list-group-item">'.$contact->phone_2.'</li>':''; ?>

    <?php if(isset($contact->company) and $contact->company != 0){ ?>
    <?php $company = $this->contact_model->find($contact->company);  ?>
    <li class="list-group-item"><?php echo anchor('contato/'.$company->slug_contact,'<i class="fa fa-building" aria-hidden="true"></i> '.$company->display_name); ?></li>
<?php } ?>

<?php if(count($tabs)){ ?>

    <?php foreach($tabs as $tab){ ?>
      <?php if(isset($tab['contact_type']) and in_array($contact->contact_type,$tab['contact_type']) or !isset($tab['contact_type'])){ ?>

        <a href="<?php echo base_url().'contato/'.$contact->slug_contact.'/'.$tab['url']; ?>"  class="list-group-item list-group-item-action <?php echo ($function_tab == $tab['url'])? 'active':''; ?> "> <?php echo $tab['label'][$current_user->language]; ?> </a>

    <?php } ?>
  <?php } ?>
<?php } ?>

  </ul>

</div>
</div>

<div class="col-md-9">

  <?php if($users_access->num_rows()){ ?>

  <div class="card mb-3">
    <div class="card-header"><i class="fa fa-key"></i>&nbsp;<?php echo lang('contact_access_by'); ?></div>
        <ul class="list-group list-group-flush">
          <div class="row">
          <?php foreach($users_access->result() as $us){ ?>
            <div class="col-md-6">
            <li class="list-group-item">
              <div class="media">
                <?php echo user_avatar($us->photo_avatar,$us->email, 60,'rounded d-flex mr-3', true,'thumbs'); ?>
                <div class="media-body row">
                  <div class="col-md-9">
                  <h5 class="mt-0"><?php echo anchor($us->username,$us->display_name); ?></h5>
                <span class="badge badge-success" ><?php echo role_user_by_id($us->role_id); ?></span>
                </div>
                        <div class="col-md-3 my-auto">
                          <?php echo anchor("contact/content/remove_access/".$us->id_access_key,'<i class="fa fa-trash"></i>','data-message="'.lang("contact_confirm_remove_access").'" class="btn btn-light exc_bot" '); ?>
              </div>
              </div>
              </div>
            </li>  </div>
          <?php } ?>
          </div>
        </ul>
    </div>

  <?php } ?>

  <div class="card">

  <?php if(is_array($contact_type) and !in_array($contact->contact_type,$contact_type)){ ?>

<div class="card-body text-center">
    <h4 class="card-title"><?php echo lang('contact_nothing_show_title'); ?></h4>
      <p class="card-text"><?php echo lang('contact_nothing_show_desc'); ?></p>

    </div>

  <?php }else{  $this->load->view($view_page); } ?>

  </div>

</div>
</div>
</div>

<script> var contact_id = <?php echo $contact->id_contact; ?>; </script>
