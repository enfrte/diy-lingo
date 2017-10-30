<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<?php echo $this->session->flashdata('message'); ?>
<?php //print_r($courses); exit;
?>
<div id="container" class="container w3-container">
  <!--<a href="<?php echo site_url('course/create/'.$language_id);?>" class="w3-btn w3-round-xlarge w3-green">Add course</a>-->
  <a href="<?php echo site_url('language/read/'); ?>" class="w3-btn-block w3-large w3-blue">Back to languages</a>

  <h2 class="w3-center w3-text-dark-grey">All <?php echo $page_header; ?></h2>

  <?php
  if(!empty($courses)) {
    foreach ($courses as $course) { ?>
      <div class="w3-panel w3-card-2 w3-light-grey">
        <h3 id="<?php echo $course->id; ?>"><?php echo $course->title; ?></h3>
        <p class="w3-text-dark-grey"><b>Description:</b>
          <?php echo (!empty($course->description) ? $course->description : 'None.'); ?>
        </p>
        <div class="w3-section">
          <?php if ($course->total_chapters > 0): ?>
            <a class="w3-btn-block w3-green" href="<?php echo site_url('chapter/index/'.$course->id); ?>">Open (<?php echo $course->total_chapters; ?>) chapters</a>
          <?php else: ?>
            <a class="w3-btn-block w3-disabled" href="#" style="pointer-events:none;">Open (<?php echo $course->total_chapters; ?>) chapters</a>
          <?php endif; ?>
          <?php if (empty($course->user_courses_id)): ?>
            <a class="w3-btn-block w3-margin-top w3-green" href="<?php echo site_url('course/save_course/'.$course->language_id.'/'.$course->id); ?>">Save course</a>
          <?php else: ?>
            <a class="w3-btn-block w3-margin-top w3-disabled" href="#" style="pointer-events:none;">Saved</a>
          <?php endif; ?>
          <!--
          <a class="w3-btn w3-round-xlarge w3-blue" href="<?php echo site_url('course/update/'.$course->language_id.'/'.$course->id); ?>">Edit</a>
          <a class="w3-btn w3-round-xlarge w3-red" href="<?php echo site_url('course/delete/'.$course->language_id.'/'.$course->id); ?>" onclick="confirmDelete(event, <?php echo $course->id; ?>)">Delete</a>
        -->
        </div>
      </div>
    <?php }
  }
  else {
    echo '<div class="w3-panel w3-card-2 w3-light-grey"><h3>No courses found</h3></div>'; }
  ?>
</div>

<script>
function confirmDelete(e, course){
  var course = document.getElementById(course).innerHTML;
  var cfm = confirm('Delete ' + course + '!?\nDeleting it will delete all courses and work related to it.');
  if(cfm == false){ e.preventDefault(); }
}
</script>
