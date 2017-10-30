<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<?php echo $this->session->flashdata('message'); ?>

<div id="container" class="container">
  <div class="w3-container w3-card-8 w3-light-grey w3-padding-top">
    <?php
    echo form_open('',array('role'=>'form'));

    echo form_label('New name for '.$language_name.' ', 'language_name');
    echo form_error('language_name');
    echo form_input('language_name', set_value('language_name'), 'class="w3-input w3-border"');

    echo form_submit('submit', 'Submit edit', 'class="w3-btn-block w3-green w3-section w3-padding"');
    echo form_close();
    ?>
  </div>
</div>
