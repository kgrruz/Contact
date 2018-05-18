

<div class="row p-3">

  <div class="col-md-3">

    <div class="card">

        <?php if(!empty($contact->is_user)){

            $user = $this->user_model->find_by('id',$contact->is_user);

            echo user_avatar($user->photo_avatar,$user->email, 224,'card-img-top img-fluid w-100', true,'med','profile_photo');

            }else{

            echo contact_avatar($contact->email, 224,'card-img-top img-fluid w-100',true,'profile_photo');

          }

          ?>

  <div class="card-body">
    <h4 class="card-title"><?php echo $contact->display_name; ?></h4>
    <p class="card-text"><?php echo mailto($contact->email); ?></p>
  </div>
  <ul class="list-group list-group-flush">
    	<?php if(isset($contact->country)){ ?>
				<li class="list-group-item">
				<i class="fa fa-map-marker" aria-hidden="true"></i>
	 <?php echo (isset($contact->city))? $contact->city:''; ?>,  <?php echo (isset($contact->state))? $contact->state:''; ?><br/>
	 <?php echo (isset($contact->neibor) and !empty($contact->neibor))? $contact->neibor.'<br/>':''; ?>
	 <?php echo (isset($contact->adress) and !empty($contact->adress))? $contact->adress:''; ?><?php echo (isset($contact->num_adress) and !empty($contact->num_adress))? '-'.$contact->num_adress:''; ?>
	  </li>
	<?php } ?>
    <?php echo (!empty($contact->phone))? '<li class="list-group-item">'.$contact->phone.'</li>':''; ?>
  </ul>

</div>

</div>

<div class="col-md-9">


  <?php if(!empty($contact->is_user)){ ?>

  <div class="card mb-3">

    <div class="card-header"><?php echo lang('parent_user_account'); ?></div>
      <div class="card-body">
  <div class="media">
    <?php echo user_avatar($user->photo_avatar,$user->email, 50,'rounded d-flex mr-3', true,'thumbs'); ?>
    <div class="media-body">
      <h5 class="mt-0"><?php echo anchor('partner/'.$user->username,$user->display_name); ?></h5>
    <?php echo $user->email; ?>
    </div>
  </div>
  </div>
    </div>

  <?php } ?>

  <div class="card">
    <?php if(count($tabs)){ ?>
    <div class="card-header">
      <ul class="nav nav-tabs card-header-tabs">
<?php foreach($tabs as $tab){ ?>
  <li class="nav-item">
    <a href="<?php echo base_url().'contato/'.$contact->slug_contact.'/'.$tab['url']; ?>"  class="nav-link <?php echo ($function_tab == $tab['url'])? 'active':''; ?> "> <?php echo $tab['label'][$current_user->language]; ?> </a>
  </li>
  <?php }  ?>
      </ul>
    </div><?php } ?>


  <?php if(isset($view_page)){ $this->load->view($view_page); } else{ ?>
<div class="text-center">
    <h4 class="card-title"><?php echo lang('contact_nothing_show_title'); ?></h4>
      <p class="card-text"><?php echo lang('contact_nothing_show_desc'); ?></p>

    </div>

  <?php } ?>


  </div>



</div>
</div>

<script> var contact_id = <?php echo $contact->id_contact; ?>; </script>
