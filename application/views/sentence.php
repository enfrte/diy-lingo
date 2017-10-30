<?php defined('BASEPATH') OR exit('No direct script access allowed');
?>
<?php echo $this->session->flashdata('message'); ?>

<div class="container w3-container">
	<a href="<?php echo site_url("chapter/authored_chapter/$course_id"); ?>" class="w3-btn-block w3-large w3-blue" style="width:100%; margin-bottom: -15px;">Back</a>
</div>

<div class="container w3-row-padding" style="margin-bottom: -15px;">
	<div class="w3-half w3-margin-top">
		<a href="<?php echo site_url("sentence/create/$course_id/$chapter_id"); ?>" class="w3-btn w3-btn-block w3-large w3-green">Add single sentence</a>
	</div>
	<div class="w3-half w3-margin-top">
		<a href="<?php echo site_url("sentence/create_batch/$course_id/$chapter_id"); ?>" class="w3-btn-block w3-large w3-green" style="width:100%">Add grouped sentences</a>
	</div>
</div>

<div id="container" class="container w3-container">

  <?php if(!empty($sentences)): ?>
    <?php foreach($sentences as $sentence): ?>
      <div class="w3-panel w3-card-2 w3-light-grey">
        <h4 id="<?php echo $sentence['id']; ?>" style="display:inline-block;">
          <?php echo xss_clean($sentence['source_sentence']) . '<br>' . xss_clean($sentence['translated_sentence']); ?>
        </h4>
        <p>
          <?php echo anchor('sentence/update/'.$course_id.'/'.$chapter_id.'/'.$sentence['id'], 'Edit', 'class="w3-btn w3-round-xlarge w3-blue"'); ?>
          <?php echo anchor('sentence/delete/'.$course_id.'/'.$chapter_id.'/'.$sentence['id'], 'Delete', array('onclick' => "confirmDelete(event, ".$sentence['id'].")", 'class'=>'w3-btn w3-round-xlarge w3-red')); ?>
        </p>
      </div>
    <?php endforeach; ?>
  <?php else: ?>
    <div class="w3-panel w3-card-2 w3-light-grey">
      <h3>No sentences found.</h3>
    </div>
  <?php endif; ?>

</div>

<script>
function confirmDelete(e, chapter){
  var chapter = document.getElementById(chapter).innerHTML;
  var cfm = confirm('Delete ' + chapter + '!?\nDeleting it will delete all chapters and work related to it.');
  if(cfm == false){ e.preventDefault(); }
}
</script>
