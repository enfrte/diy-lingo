<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<?php echo $this->session->flashdata('message'); ?>
<?php echo validation_errors(); ?>

<div id="container" class="container">
  <div class="w3-container w3-card-8 w3-light-grey w3-padding-top">

  <?php
  //print_r($chapters);
  // http://stackoverflow.com/questions/11133540/adding-class-and-id-in-form-dropdown
  //if(!empty($chapters)){
  echo form_open('', array('role'=>'form'));
    // Select dropdown
    /*
    echo form_label('Select chapter', '');
    echo form_error('select_chapter'); // see set_rules($field_name[, $field_label[, $rules]])
    echo form_dropdown(array('id'=>'select_chapter', 'name'=>'select_chapter', 'class' => 'w3-input w3-border w3-margin-bottom'), $chapters_select_dropdown, '');
    */ 
  // Input source
  $source_sentence = array('name' => 'source_sentence', 'id' => 'source_sentence', 'style'=>'display:block;');
  echo form_label('Source sentence ','source_sentence');
  echo form_error('source_sentence');
  echo form_input($source_sentence, set_value('source_sentence'), 'class="w3-input w3-border w3-margin-bottom"');
  // Input translation
  $translated_sentence = array('name' => 'translated_sentence', 'id' => 'translated_sentence', 'style'=>'display:block;');
  echo form_label('Translated sentence ','translated_sentence');
  echo form_error('translated_sentence');
  echo form_input($translated_sentence, set_value('translated_sentence'), 'class="w3-input w3-border w3-margin-bottom"');
  // Input alternative translation
  $alt_translated_sentence = array('name' => 'alt_translated_sentence[]', 'style'=>'display:block;');
  echo form_label('Alternative translation ','alt_translated_sentence[]');
  echo form_error('alt_translated_sentence[]');
  echo form_input($alt_translated_sentence, set_value('alt_translated_sentence[]'), 'class="w3-input w3-border w3-margin-bottom"');
  // Input alternative translation
  echo form_label('Alternative translation ','alt_translated_sentence[]');
  echo form_error('alt_translated_sentence[]');
  echo form_input($alt_translated_sentence, set_value('alt_translated_sentence[]'), 'class="w3-input w3-border w3-margin-bottom"');
  // Input alternative translation
  echo form_label('Alternative translation ','alt_translated_sentence[]');
  echo form_error('alt_translated_sentence[]');
  echo form_input($alt_translated_sentence, set_value('alt_translated_sentence[]'), 'class="w3-input w3-border w3-margin-bottom"');
  // Input alternative translation
  echo form_label('Alternative translation ','alt_translated_sentence[]');
  echo form_error('alt_translated_sentence[]');
  echo form_input($alt_translated_sentence, set_value('alt_translated_sentence[]'), 'class="w3-input w3-border w3-margin-bottom"');
  // Submit button
  echo form_submit('submit', 'Create sentence', 'class="w3-btn-block w3-green w3-section w3-padding"');
  echo form_close();
  /*}
  else {
    echo '<h3>No chapters available.</h3><h3>Create at least one chapter before creating a sentence for it.</h3>';
  }*/
  ?>

  </div>
</div>
