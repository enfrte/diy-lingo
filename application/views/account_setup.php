<?php defined('BASEPATH') OR exit('No direct script access allowed');?>

<div id="container" class="container">
  <?php
    if(!empty( $this->session->flashdata() )) { 
        foreach ($this->session->flashdata() as $key => $value) {
          echo '<div class="w3-panel w3-center w3-padding w3-red">'.$this->session->flashdata($key).'</div>'; 
        }
      }
    ?>
  <div class="w3-container w3-card-8 w3-light-grey w3-padding-top">
    <p>
      This form is used to create the first (admin) user. The form action will only complete if there are no users registered in the system.
    </p>
    <?php
    echo validation_errors();

    echo form_open('', array('role'=>'form'));

    echo form_label('Admin email','login');
    echo form_error('login'); // feild specific error - like required
    echo form_input('login', '', array('id'=>'login', 'class' => 'w3-input w3-border w3-margin-bottom', 'placeholder' => 'Enter email'));

    echo form_label('Password','password');
    echo form_error('password');
    echo form_password('password', '', array('id'=>'password', 'class' => 'w3-input w3-border w3-margin-bottom', 'placeholder' => 'Enter password'));

    echo form_submit('submit', 'Log in', 'class="w3-btn-block w3-green w3-section w3-padding"');

    echo form_close();
    ?>
  </div>
</div>
