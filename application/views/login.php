<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<div id="container" class="container">
  
  <a href="<?php echo site_url("account/create/"); ?>" class="w3-btn-block w3-large w3-yellow w3-margin-bottom">Not Registered? Create an account</a>

  <?php echo $showMessages; ?>
  
  <div class="w3-container w3-card-8 w3-light-grey w3-padding-top">
  <?php
    echo form_open('', array('role'=>'form', 'autocomplete' =>'on'));

    echo form_label('Email','login');
    echo form_error('login'); // feild specific error - like required
    echo form_input('login', '', array('id'=>'login', 'class' => 'w3-input w3-border w3-margin-bottom', 'placeholder' => 'Enter email'));

    echo form_label('Password','password');
    echo form_error('password');
    echo form_password('password', '', array('id'=>'password', 'class' => 'w3-input w3-border w3-margin-bottom', 'placeholder' => 'Enter password'));

    echo form_checkbox('remember', '1', FALSE, array('id'=>'remember'));
    echo form_label('Remember me', 'remember', 'class="w3-check w3-margin-top"');

    echo form_submit('submit', 'Log in', 'class="w3-btn-block w3-green w3-section w3-padding"');

    echo form_close();
  ?>
  </div>
</div>
