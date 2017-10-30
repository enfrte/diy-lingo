<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<?php echo $this->session->flashdata('message'); ?>

<div id="container" class="container">
  <div class="w3-container w3-card-8 w3-light-grey w3-padding-16">
    <?php
    echo form_open('',array('role'=>'form'));

    echo form_label('Language name ','language_name');
    echo form_error('language_name');
    $language_name_data = ['name' => 'language_name', 'id' => 'language_name', 'class' => 'w3-input w3-border w3-margin-bottom'];
    echo form_input($language_name_data);

    echo form_label('Select a flag icon ','country_code');
    echo form_error('country_code');
    $data = array(
      'type'  => 'hidden',
      'name'  => 'country_code',
      'id'    => 'country_code',
    );
    echo form_input($data);

    echo '<div id="flag-container" class="flag-container" style="background-color:darkgray;padding:15px;width:100%;text-align:center;color:#333;">Enter a language for flags to be displayed</div>';

    //echo form_label('Country code (must match flag codes in images folder)','country_code');
    //echo form_error('country_code');
    //echo form_input('country_code',set_value('country_code'),'class="w3-input w3-border"');

    echo form_submit('submit', 'Create language', 'class="w3-btn-block w3-green w3-section w3-padding"');

    //echo form_label('Search languages ','country_code');
    //echo form_error('country_code');
    //$country_code_data = ['name' => 'country_code', 'id' => 'country_code', 'class' => 'w3-input w3-border w3-margin-bottom'];
    //echo form_input($country_code_data);

    echo form_close();
    ?>
  </div>
</div>
