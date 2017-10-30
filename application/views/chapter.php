<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<?php echo $this->session->flashdata('message'); ?>

<div class="container w3-container">
  <?php if($this->router->method !== 'authored_chapter'): ?>
    <a href="<?php echo site_url("course/index/$course_data->language_id"); ?>" class="w3-btn-block w3-large w3-blue">Back to courses</a>
  <?php endif; ?>
</div>

<h2 class="w3-center w3-text-dark-grey"><?php echo $course_data->title; ?></h2>

<?php /* note: $course_owner can be NULL if no chapters */ ?>
<?php if($course_owner === $this->current_user_id && $this->router->fetch_method() === 'authored_chapter'): ?>

  <div class="container w3-row-padding" style="margin-top:-15px;margin-bottom:-15px;">
    <div class="w3-half w3-margin-top">
      <a href="<?php echo site_url('chapter/create/'.$course_id); ?>" class="w3-btn-block w3-large w3-green" style="width:100%">Add chapter</a>
    </div>
    <div class="w3-half w3-margin-top">
      <a href="<?php echo site_url('course/authored_course/'); ?>" class="w3-btn-block w3-large w3-blue" style="width:100%">Back</a>
    </div>
  </div>

<?php endif; ?>

<div id="container" class="container w3-container">

  <?php if(!empty($chapters)): ?>
    <?php foreach ($chapters as $chapter): ?>
      <div class="w3-panel w3-card-2 w3-light-grey">

        <?php if($chapter->course_owner === $this->current_user_id && $this->router->fetch_method() === 'authored_chapter'): ?>
        <div class="w3-dropdown-hover w3-right w3-margin-top">
          <button class="w3-btn w3-blue">Author menu &#9660;</button>
          <div class="w3-dropdown-content w3-border" style="right:0; z-index:1;">
            <a href="<?php echo site_url('sentence/index/'.$chapter->course_id.'/'.$chapter->id); ?>">Add/Edit sentences</a>
            <a href="<?php echo site_url('chapter/tutorial_update/'.$chapter->course_id.'/'.$chapter->id); ?>">Add/Edit tutorial</a>
            <a href="<?php echo site_url('chapter/update/'.$chapter->course_id.'/'.$chapter->id); ?>">Edit title</a>
            <a href="<?php echo site_url('chapter/delete/'.$chapter->course_id.'/'.$chapter->id); ?>" onclick="confirmDelete(event, <?php echo "'title_{$chapter->id}'"; ?>, 'sentences')">Delete chapter</a>
          </div>
        </div>
        <?php endif; ?>

        <h3 id="<?php echo 'title_'.$chapter->id; ?>"><?php echo $chapter->title; ?></h3>

        <div class="w3-section">
          <?php if($chapter->total_sentences > 0): ?>
            <a class="w3-btn-block w3-margin-top w3-green" href="<?php echo site_url('sentence/practice/'.$chapter->id); ?>">Practice sentences (<?php echo $chapter->total_sentences; ?>)</a>
          <?php else: ?>
            <a class="w3-btn-block w3-margin-top w3-disabled" href="<?php echo site_url('sentence/practice/'.$chapter->id); ?>" style="pointer-events:none;">Practice sentences (<?php echo $chapter->total_sentences; ?>)</a>
          <?php endif; ?>
          <?php if ($chapter->tutorial_length): ?>
            <a class="w3-btn-block w3-margin-top w3-green" href="<?php echo site_url('chapter/tutorial_read/'.$chapter->id); ?>">Open tutorial</a>
          <?php else: ?>
            <a class="w3-btn-block w3-margin-top w3-disabled" href="<?php echo site_url('chapter/tutorial_read/'.$chapter->id); ?>" style="pointer-events:none;">Missing tutorial</a>
          <?php endif; ?>
        </div>

      </div>
    <?php endforeach; ?>
  <?php else: ?>
    <div class="w3-panel w3-card-2 w3-light-grey">
      <h3>No chapters found</h3>
    </div>
  <?php endif; ?>

</div>
