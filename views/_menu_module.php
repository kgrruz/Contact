<ul class="nav nav-tabs flex-column flex-sm-row card-header-tabs">
  <li class="nav-item">
   <?php echo anchor('contacts',lang('contact_list'),'class="nav-link '.check_segment(1,'contacts',true).'"'); ?>
  </li>
  <li class="nav-item">
      <?php echo anchor('contact/create',lang('bf_action_create'),'class="nav-link '.check_url('contact/create',true).check_url('contact/create/1',true).'"'); ?>
  </li>

    <li class="nav-item dropdown">
     <a class="nav-link dropdown-toggle" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false"><?php echo lang('group_module_name'); ?></a>
     <div class="dropdown-menu">
       <?php echo anchor('contact/group/',lang('group_list'),'class="dropdown-item '.check_url('contact/group',true).'"'); ?>
       <?php echo anchor('contact/group/create',lang('bf_action_create'),'class="dropdown-item '.check_url('contact/group/create',true).'"'); ?>
     </div>
   </li>
</ul>
