<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<?php echo $this->session->flashdata('message'); ?>
<?php echo validation_errors(); ?>

<div id="container" class="container">
  <div class="w3-container w3-card-8 w3-light-grey w3-padding-top">
  <?php
    echo form_open('',array('role'=>'form'));
    // Input
    echo form_label('Chapter name ','chapter_name');
    echo form_error('chapter_name');
    echo form_input('chapter_name', '', 'id="chapter_name" class="w3-input w3-border" placeholder="Enter chapter title"');
    // Submit button
    echo form_submit('submit', 'Create chapter', 'class="w3-btn-block w3-green w3-section w3-padding"');
    echo form_close();
  ?>
  </div>
</div>
