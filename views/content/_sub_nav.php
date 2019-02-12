<?php

$checkSegment = $this->uri->segment(4);
$areaUrl = SITE_AREA . '/content/contact/';
?>
 <ul class="nav nav-tabs card-header-tabs">
	 <li class="nav-item">
		<?php echo anchor($areaUrl,lang('contact_list'),'class="nav-link '.check_url($areaUrl,true).'"'); ?>
	 </li>


		 <li class="nav-item dropdown">
			<a class="nav-link dropdown-toggle" id="add_contact_nav" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false"><?php echo lang('bf_action_create'); ?></a>
			<div class="dropdown-menu">
				<?php echo anchor($areaUrl.'create/','<i class="fa fa-user"></i> '.lang('contact_contact'),'id="add_contact_person" class="dropdown-item '.check_url($areaUrl.'create',true).'"'); ?>
				<?php echo anchor($areaUrl.'create/2','<i class="fa fa-building"></i> '.lang('contact_company'),'id="add_contact_company"  class="dropdown-item '.check_url($areaUrl.'create/2',true).'"'); ?>
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
