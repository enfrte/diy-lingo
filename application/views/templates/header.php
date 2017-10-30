<?php defined('BASEPATH') OR exit('No direct script access allowed');
?><!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title><?php echo $page_title ?></title>
<!-- Uses W3.CSS http://www.w3schools.com/w3css/default.asp -->
<link rel="stylesheet" href="http://www.w3schools.com/lib/w3.css">
<link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css/main.css');?>">
<?php 
  if(isset($before_head)) { echo $before_head; } // link external CSS or JS
?>
</head>
<?php if($this->router->method !== 'practice'): ?>
  <body class="w3-light-blue">
<?php else: ?>
  <body>
<?php endif; ?>

<nav>
  <ul class="w3-navbar w3-light-grey w3-large">
  <!--<li><a href="<?php echo site_url('home/'); ?>">Home</a></li>-->
  <li><a href="<?php echo site_url('language/read/'); ?>">Browse courses</a></li>
  <li><a href="<?php echo site_url('course/saved_courses/'); ?>">Saved courses</a></li>
  <li><a href="<?php echo site_url('course/authored_course/'); ?>">Authored courses</a></li>
  <!--
  <a href="<?php echo site_url('feedback/'); ?>">Feedback</a>
  -->
  <?php if($this->ion_auth->logged_in()): ?>
    <li class="w3-right"><a href="<?php echo site_url('account/logout'); ?>">Logout: </i><?php echo (isset($this->current_user_id)) ? $this->current_user_id : 'ID not found'; ?></a></li>
    <!-- To use icons, include the icon library
      <li><a href="<?php echo site_url('account/logout'); ?>"><i class="fa fa-sign-in"></i><?php echo (isset($this->current_user_id)) ? $this->current_user_id : 'ID not found'; ?></a></li>
    -->
  <?php else: ?>
    <li class="w3-right"><a href="<?php echo site_url('account/login'); ?>">Login</i></a></li>
  <?php endif; ?>
  </ul>
</nav>

<div class="w3-container w3-blue w3-center">
  <?php if($this->router->method === 'practice'): ?>
    <h1 class="w3-xlarge"><?php echo $page_header; ?></h1>
  <?php elseif($this->router->fetch_class() === 'home'): ?>
    <h1 class="w3-jumbo"><?php echo $page_header; ?></h1>
  <?php else: /* Set default */ ?>
    <h1 class="w3-xxxlarge"><?php echo $page_header; ?></h1>
  <?php endif; ?>
</div>

<?php
  //echo '<pre>Session log: ' ; print_r($_SESSION); echo '</pre>';
?>
