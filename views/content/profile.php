
<div class="row">
  <div class="col-md-3">

    <div class="card">

        <?php echo contact_avatar($contact->email, 224,'card-img-top img-fluid w-100',true,'profile_photo');  ?>

  <div class="card-body">
    <h4 class="card-title"><?php echo ($contact->contact_type == 1)? '<i class="fa fa-user" aria-hidden="true"></i>':'<i class="fa fa-building" aria-hidden="true"></i>'; ?> <?php echo (isset($contact->is_user))? '<i class="fa fa-key"></i>':''; ?> <?php echo $contact->display_name; ?> </h4>
    <?php echo anchor('admin/content/contact/edit/'.$contact->slug_contact,'<i class="fa fa-edit" aria-hidden="true"></i> '.lang('contact_action_edit')); ?>
      <?php echo (!empty($contact->job_role))? '<p class="card-text">'.$contact->job_role.'</p>':''; ?>
    <p class="card-text"><?php echo mailto($contact->email); ?></p>
  </div>
  <ul class="list-group list-group-flush">

    	<?php if(isset($contact->country)){ ?>
				<li class="list-group-item">
				<i class="fa fa-map-marker" aria-hidden="true"></i>
	 <?php echo (isset($contact->city))? $contact->city:lang("contact_city_indef"); ?>,  <?php echo (isset($contact->state))? $contact->state:''; ?>
   <?php echo anchor("contact/complete_geo/".$contact->slug_contact,lang("contact_set_coordinate"),"class='float-right'"); ?>
   <br/>
	 <?php echo (isset($contact->neibor) and !empty($contact->neibor))? $contact->neibor.'<br/>':''; ?>
	 <?php echo (isset($contact->adress) and !empty($contact->adress))? $contact->adress:''; ?><?php echo (isset($contact->num_adress) and !empty($contact->num_adress))? '-'.$contact->num_adress:''; ?>
	  </li>
	<?php } ?>

    <?php echo (!empty($contact->phone))? '<li class="list-group-item">'.$contact->phone.'</li>':''; ?>
    <?php echo (!empty($contact->phone_2))? '<li class="list-group-item">'.$contact->phone_2.'</li>':''; ?>

    <?php if(isset($contact->company) and $contact->company != 0){ ?>
    <?php $company = $this->contact_model->find($contact->company);  ?>
    <li class="list-group-item"><?php echo anchor('admin/content/contact/profile/'.$company->slug_contact,'<i class="fa fa-building" aria-hidden="true"></i> '.$company->display_name); ?></li>
<?php } ?>

<?php if(count($tabs)){ ?>

    <?php foreach($tabs as $tab){ ?>
      <?php if(isset($tab['contact_type']) and in_array($contact->contact_type,$tab['contact_type']) or !isset($tab['contact_type'])){ ?>

        <a href="<?php echo base_url().'admin/content/contact/profile/'.$contact->slug_contact.'/'.$tab['url']; ?>"  class="list-group-item list-group-item-action <?php echo ($function_tab == $tab['url'])? 'active':''; ?> "> <?php echo $tab['label'][$current_user->language]; ?> </a>

    <?php } ?>
  <?php } ?>
<?php } ?>

  </ul>

</div>
</div>

<div class="col-md-9">


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
</div>

<script> var contact_id = <?php echo $contact->id_contact; ?>; </script>
