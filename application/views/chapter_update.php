<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<?php echo $this->session->flashdata('message'); ?>
<?php echo validation_errors(); ?>

<div id="container" class="container">
  <div class="w3-panel w3-card-2 w3-light-grey w3-padding-top">


  <?php echo $this->session->flashdata('message');?>
  <?php echo form_open('',array('role'=>'form'));?>

  <?php
    echo form_label('New name for '.$chapter_title.' ', 'chapter_title');
    echo form_error('chapter_title');
    echo form_input('chapter_title', '', array('placeholder' => $chapter_title, 'class'=>'w3-input w3-border'));
  ?>

  <?php echo form_submit('submit', 'Submit edit', 'class="w3-btn-block w3-green w3-section w3-padding"');?>
  <?php echo form_close();?>

  </div>
</div>
