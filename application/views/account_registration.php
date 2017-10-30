<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<div id="container" class="container">
  <?php echo $showMessages; ?>

  <div class="w3-container w3-card-8 w3-light-grey w3-padding-top">
    <p>Submit your email address and unique password to register as a user on this site.</p>
    <?php
    echo form_open('', array('role'=>'form'));

    echo form_label('User email','login');
    echo form_error('login'); // feild specific error - like required
    echo form_input('login', '', array('id'=>'login', 'class' => 'w3-input w3-border w3-margin-bottom', 'placeholder' => 'Enter email'));

    echo form_label('Password','password');
    echo form_error('password');
    echo form_password('password', '', array('id'=>'password', 'class' => 'w3-input w3-border w3-margin-bottom', 'placeholder' => 'Enter password'));

    echo form_submit('submit', 'Create account', 'class="w3-btn-block w3-green w3-section w3-padding"');

    echo form_close();
    ?>
  </div>
</div>
