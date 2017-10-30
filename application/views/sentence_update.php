<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<?php echo $this->session->flashdata('message'); ?>

<div id="container" class="container">
  <div class="w3-container w3-card-8 w3-light-grey w3-padding-top">
  <?php echo validation_errors(); ?>

  <?php
  // http://stackoverflow.com/questions/11133540/adding-class-and-id-in-form-dropdown
  echo form_open('', array('role'=>'form'));
  // Input source
  $source_sentence = array('name' => 'source_sentence', 'id' => 'source_sentence');
  echo form_label('Source sentence ','source_sentence');
  echo form_error('source_sentence');
  echo form_input($source_sentence, set_value('source_sentence', $sentence['source_sentence']), 'class="w3-input w3-border w3-margin-bottom"');
  // Input translation
  $translated_sentence = array('name' => 'translated_sentence', 'id' => 'translated_sentence');
  echo form_label('Translated sentence ','translated_sentence');
  echo form_error('translated_sentence');
  echo form_input($translated_sentence, set_value('translated_sentence', $sentence['translated_sentence']), 'class="w3-input w3-border w3-margin-bottom"');
  // Input alternative translation
  foreach ($sentence['alt_translations'] as $value) {
    // even if there are no current alt_translations, this will always return one empty result, because there will always be one source/translation result.
    // so test if the result is empty before assigning it
    if (is_null($value['alt_translation_id'])) { continue; } // skip current iteration
    $alt_translated_sentence = array(
      'name' => 'alt_translated_sentence[id_'. $value['alt_translation_id'] .']',
      'value' => set_value('alt_translated_sentence[id_'. $value['alt_translation_id'] .']', $value['alt_translated_sentence']),
      'class' => 'w3-input w3-border',
    );
    echo form_label('Alternative translation ','alt_translated_sentence[id_'. $value['alt_translation_id'] .']');
    // this error checking definition property is non indexed therefore cannot detect which error field the error is happening on.
    // the validation_errors() function can display the error message generally at the top of the page.
    // to get individual error feedback for each field, I could dynamically create the validation rules in the controller for each field. but some other time
    //echo form_error('alt_translated_sentence[]');
    echo form_input($alt_translated_sentence);
  }
  // if there are less than 5 existing alt translations, add the difference in empty fields, this is in case the user wants to add more at this point
  
  if( count($sentence['alt_translations']) < 5 ) {
    for ($i = count($sentence['alt_translations']); $i < 5; $i++) { 
      echo form_label('Alternative translation ','alt_translated_sentence[]');
      // this error checking definition property is non indexed therefore cannot detect which error field the error is happening on.
      // the validation_errors() function can display the error message generally at the top of the page.
      //echo form_error('alt_translated_sentence[]');
      echo form_input(array('name' => 'alt_translated_sentence[]'), '', 'class="w3-input w3-border"');
    }
  }
  // Submit button
  echo form_submit('submit', 'Update sentence', 'class="w3-btn-block w3-green w3-section w3-padding"');
  echo form_close();

  ?>

  </div>
</div>
