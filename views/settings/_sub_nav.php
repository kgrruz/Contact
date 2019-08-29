<?php

$checkSegment = $this->uri->segment(4);
$areaUrl = SITE_AREA . '/settings/contact';

?>
<ul class="nav nav-pills">
  <li class="nav-item">
	<li<?php echo $checkSegment == '' ? ' class="nav-item"' : 'class="nav-item"'; ?>>
		<a href="<?php echo site_url($areaUrl); ?>" class="nav-link active" id='list'>
            <?php echo lang('contact_settings'); ?>
        </a>
	</li>

</ul>
