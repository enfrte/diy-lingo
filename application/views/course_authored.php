<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<?php echo $this->session->flashdata('message'); ?>
<?php //print_r($courses);
?>
<div id="container" class="container w3-container">
  <a href="<?php echo site_url('course/create/'); ?>" class="w3-btn w3-btn-block w3-large w3-green">Create new course</a>

  <?php if(!empty($courses)): ?>
    <?php foreach ($courses as $course): ?>

      <div class="w3-panel w3-card-2 w3-light-grey">

        <div class="w3-dropdown-hover w3-right w3-margin-top">
          <button class="w3-btn w3-blue">Author menu &#9660;</button>
          <div class="w3-dropdown-content w3-border" style="right:0; z-index:1;">
            <a href="<?php echo site_url('chapter/authored_chapter/'.$course->course_id); ?>">Add/Edit chapters</a>
            <a href="<?php echo site_url('course/update/'.$course->language_id.'/'.$course->course_id); ?>">Edit name</a>
            <a href="<?php echo site_url('course/update_description/'.$course->course_id); ?>">Edit description</a>
            <a href="<?php echo site_url('course/delete/'.$course->course_id); ?>" onclick="confirmDelete(event, <?php echo "'title_{$course->course_id}'"; ?>, 'chapters')">Delete course</a>
            <!--<a href="<?php echo site_url('tutorial/update/'.$course->language_id.'/'.$course->course_id); ?>">Edit tutorial</a>-->
          </div>
        </div>

        <h3 id="<?php echo 'title_'.$course->course_id; ?>"><?php echo $course->title; ?></h3>
        <p class="w3-text-dark-grey"><b>Language:</b> <?php echo $course->language; ?></p>
        <p class="w3-text-dark-grey"><b>Description:</b>
          <?php echo (!empty($course->description) ? $course->description : 'No description set. Use the author menu to set a description.'); ?>
        </p>
          <!--
          <a class="w3-btn w3-green" href="<?php echo site_url('chapter/index/'.$course->course_id); ?>">Open chapters</a>
          <a class="w3-btn w3-green" href="<?php echo site_url('course/unsave_course/'.$course->course_id); ?>">Remove saved course</a>
        -->
      </div>
    <?php endforeach; ?>
  <?php else: ?>
    <div class="w3-panel w3-card-2 w3-light-grey w3-center"><h3>You have no authored courses.</h3></div>
  <?php endif; ?>
</div>

<script>
/*
function authorMenu(course_id) {
  // I think there is a better way to do this in JS
  var x = document.getElementById(course_id);
  if (x.className.indexOf("w3-show") == -1) {
    x.className += " w3-show";
  } else {
    x.className = x.className.replace(" w3-show", "");
  }
}
*/
</script>
