<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<?php echo $this->session->flashdata('message'); ?>
<?php //print_r($); exit;
?>
<div id="container" class="container w3-container">

  <?php
  if(!empty($courses)) {
    foreach ($courses as $course) { ?>
      <div class="w3-panel w3-card-2 w3-light-grey">
        <h3 id="<?php echo $course->course_id; ?>"><?php echo $course->title; ?></h3>
        <p class="w3-text-dark-grey"><b>Language:</b> <?php echo $course->language; ?></p>
        <p class="w3-text-dark-grey"><b>Description:</b>
          <?php echo (!empty($course->description) ? $course->description : 'None.'); ?>
        </p>
        <div class="w3-row">
          <a class="w3-btn-block w3-green" href="<?php echo site_url('chapter/index/'.$course->course_id); ?>">Open chapters</a>
          <a class="w3-btn-block w3-margin-top w3-red" href="<?php echo site_url('course/unsave_course/'.$course->course_id); ?>">Remove saved course</a>
        </div>
        </p>
      </div>
    <?php }
  }
  else {
    echo '<div class="w3-panel w3-card-2 w3-light-grey"><h3>No saved courses found</h3></div>';
  } ?>
</div>

<script>
function confirmDelete(e, course){
  var course = document.getElementById(course).innerHTML;
  var cfm = confirm('Delete ' + course + '!?\nDeleting it will delete all courses and work related to it.');
  if(cfm == false){ e.preventDefault(); }
}
</script>
