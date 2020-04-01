<?php

$checkSegment = $this->uri->segment(4);
$areaUrl = SITE_AREA . '/content/contact';
?>
 <ul class="nav nav-pills ">
	 <li class="nav-item">
		<?php echo anchor('contatos',lang('contact_list'),'class="nav-link '.check_segment(1,'contatos',true).'"'); ?>
	 </li>


		 <li class="nav-item dropdown">
			<a class="nav-link dropdown-toggle" id="add_contact_nav" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false"><?php echo lang('bf_action_create'); ?></a>
			<div class="dropdown-menu">
				<?php echo anchor('add_contato/','<i class="fa fa-user"></i> '.lang('contact_contact'),'id="add_contact_person" class="dropdown-item '.check_url('add_contato',true).'"'); ?>
				<?php echo anchor('add_contato/2','<i class="fa fa-building"></i> '.lang('contact_company'),'id="add_contact_company"  class="dropdown-item '.check_url('add_contato/2',true).'"'); ?>
			</div>
		</li>
		 <li class="nav-item dropdown">
			<a class="nav-link dropdown-toggle" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false"><?php echo lang('group_module_name'); ?></a>
			<div class="dropdown-menu">
				<?php echo anchor('contact/group/',lang('group_list'),'class="dropdown-item '.check_url('contact/group',true).'"'); ?>
				<?php echo anchor('contact/group/create',lang('bf_action_create'),'class="dropdown-item '.check_url('contact/group/create',true).'"'); ?>
			</div>
		</li>
</ul>
