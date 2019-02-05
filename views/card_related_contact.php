<div class="card mb-3">
 <div class="card-header"><i class="fa fa-key"></i>&nbsp;<?php echo lang('contact_access_to'); ?></div>

 <ul class="list-group list-group-flush">

     <?php foreach($contacts as $contact){  ?>
            <li class="list-group-item">
<div class="media">
 <?php echo contact_avatar($contact->email, 50,'rounded d-flex mr-3', true,'thumbs'); ?>
 <div class="media-body">
   <h5 class="mt-0"><?php echo anchor('contato/'.$contact->slug_contact,$contact->display_name); ?></h5>
 <?php echo $contact->email; ?>
 </div>
</div>
</li>
<?php } ?>
</ul>
 </div>
