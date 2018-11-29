<div class="card-body">

<h2 class="Subhead-heading"><?php echo $toolbar_title; ?></h2>
    <p class="Subhead-description">
      <?php echo lang('group_desc_form_create'); ?>
    </p>


  <?php echo form_open($this->uri->uri_string()); ?>
    <?php if (validation_errors()) : ?>

<div class='alert alert-block alert-error'>
    <a class='close' data-dismiss='alert'>&times;</a>
    <h4 class='alert-heading'>
        <?php echo lang('group_errors_message'); ?>
    </h4>
    <?php echo validation_errors(); ?>
</div>
<?php
endif;

$id = isset($group->id_group) ? $group->id_group : '';

?>
  <div class="row">
  <div class="col-md-6">
            <div class="form-group<?php echo form_error('group_name') ? ' error' : ''; ?>">
                <?php echo form_label(lang('group_field_group_name') . lang('bf_form_label_required'), 'group_name', array('class' => 'control-label')); ?>

                    <input id='group_name' type='text' class="form-control form-control-sm" required='required' name='group_name' maxlength='255' value="<?php echo set_value('group_name', isset($group->group_name) ? $group->group_name : ''); ?>" />
                    <span class='help-inline'><?php echo form_error('group_name'); ?></span>

            </div>


            <div class="form-group<?php echo form_error('description') ? ' error' : ''; ?>">
                <?php echo form_label(lang('group_field_description'), 'description', array('class' => 'control-label')); ?>

                    <textarea id='description' rows="5" type='text' placeholder="<?php echo lang('group_placeholder_description'); ?>" class="form-control form-control-sm" name='description' ><?php echo set_value('description', isset($group->description) ? $group->description : ''); ?></textarea>
                    <span class='help-inline'><?php echo form_error('description'); ?></span>

            </div>

            <div class="form-group<?php echo form_error('parent_group') ? ' error' : ''; ?>">
                <?php echo form_label(lang('group_field_parent_group') . lang('bf_form_label_required'), 'parent_group', array('class' => 'control-label')); ?>

<select name="parent_group" class="form-control form-control-sm" >
  <?php if(count($tree['items'])){ foreach($tree['items'] as $groupp){ ?>
  <option <?php echo (isset($group) and $group->parent_group == $groupp['id_group'])? 'selected':''; ?>
     value="<?php echo $groupp['id_group']; ?>" >
  <?php echo str_repeat('-', $this->nested_set->getNodeLevel($groupp)*4); ?>
  <?php echo ucfirst($groupp['group_name']); ?>
  </option>
<?php } }else{ ?><option value="0"><?php echo lang('group_no_records'); ?></option><?php } ?>
</select>
                    <span class='help-inline'><?php echo form_error('parent_group'); ?></span>

            </div>


            </div>


<?php echo form_input(array('name'=>'save','type'=>'hidden','value'=>lang('group_action_create'))); ?>


            </div>
            </div>

          <div class="card-footer">
                <input type='submit' value="<?php echo lang('group_action_create'); ?>" class='btn btn-sm btn-primary' />
                <?php echo lang('bf_or'); ?>
                <?php echo anchor('contact/group', lang('group_cancel'), 'class="btn btn-sm btn-warning"'); ?>
  </div>

  <?php echo form_close(); ?>
