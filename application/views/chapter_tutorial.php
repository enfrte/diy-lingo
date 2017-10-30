<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<div id="container" class="container" style="max-width:768px;">
<a href="<?php echo site_url("chapter/index/".$chapter_tutorial['course_id']); ?>" class="w3-btn-block w3-large w3-blue">Back to Chapters</a>

<?php echo validation_errors(); ?>

  <div class="w3-panel w3-card-2 w3-white w3-padding-top">
    <h1><?php echo xss_clean($chapter_tutorial['title']); ?></h1>
    <hr style="border: 1px solid #ccc;">

    <div class="w3-margin-bottom">
      <?php echo xss_clean($chapter_tutorial['tutorial']); /* html formatted text */ ?>
    </div>
  </div>

</div>
