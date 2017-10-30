<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<div id="container" class="container">

<?php
  //print_r($select_test);
?>
  <?php foreach ($select_test as $value): ?>
  <?php if (isset($value['chapter_id'])): ?>
  <div style="background-color:lightblue;margin:5px;padding:15px;">
    <h3>
      <?php echo $value['language_name'] . ' / ' . $value['course_title'] . ' / ' . $value['chapter_title']; ?>
    </h3>
    <?php echo anchor('exam/take_exam/'. $value['chapter_id'], 'Take test'); ?>
  </div>
  <?php endif; ?>
  <?php endforeach; ?>

</div>
