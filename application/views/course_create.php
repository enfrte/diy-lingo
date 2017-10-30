<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<?php echo $this->session->flashdata('message'); ?>

<div id="container" class="container">
  <div class="w3-container w3-card-8 w3-light-grey w3-padding-top">

  <?php
  echo form_open('',array('role'=>'form'));
  // http://stackoverflow.com/questions/11133540/adding-class-and-id-in-form-dropdown

  if(!empty($languages)){
    $language = [];
    $language['unselected'] = "Select";
    foreach ($languages as $lang) {
      $language[$lang->id] = $lang->language;
    }
  }
  //print_r($lang);
  echo form_label('Select language', 'select_language');
  echo form_error(''); // see set_rules($field_name[, $field_label[, $rules]])
  echo form_dropdown('', $language, '', 'id="select_language" name="select_language" class="w3-select w3-border w3-margin-bottom"');

  echo form_label('Course title ','course_title');
  echo form_error('course_title');
  echo form_input('course_title',set_value('course_title'), 'id="course_title" class="w3-input w3-border" placeholder="Enter course title"');
  ?>

  <?php echo form_submit('submit', 'Create Course', 'class="w3-btn-block w3-green w3-section w3-padding"');?>
  <?php echo form_close();?>

</div>
</div>
