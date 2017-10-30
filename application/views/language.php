<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<?php echo $this->session->flashdata('message'); ?>

<div class="container w3-row w3-center" style="max-width: 992px;">

<?php if ($this->ion_auth->in_group('admin')): ?>
  <div class="w3-center w3-padding">
    <a href="<?php echo site_url('language/create');?>" class="w3-btn-block w3-large w3-green">Add language</a>
  </div>
<?php endif; ?>

<div class="w3-container">
  <div class="w3-card-2 w3-padding w3-light-grey">
    <?php
    echo form_open('', array('role'=>'form'));
    echo form_label('', 'search', 'class="w3-label"');
    echo form_error('search');
    echo form_input('search', '', 'class="w3-input w3-border" placeholder="Search (empty submission returns all languages)"');
    //echo form_submit('submit', 'Search', 'class="w3-btn-block w3-green w3-section w3-padding"');
    echo form_close();
    ?>
  </div>
</div>

<?php if (!empty($languages)): ?>
  <?php foreach ($languages as $language): ?>
    <div class="w3-third w3-panel">

      <div class="w3-card-2 w3-padding w3-light-grey">
        <?php if( $this->ion_auth->in_group('admin') ): ?>
        <div class="w3-dropdown-hover w3-margin-top" style="display:block;">
          <button class="w3-btn-block w3-blue">Admin menu &#9660;</button>
          <div class="w3-dropdown-content w3-border" style="right:0; z-index:1;">
            <a href="<?php echo site_url('language/update/'.$language->id); ?>">Edit title</a>
            <a href="<?php echo site_url('language/delete/'.$language->id); ?>" onclick="confirmDelete(event, <?php echo "'title_{$language->id}'"; ?>, 'languages')">Delete language</a>
          </div>
        </div>
        <?php endif; ?>

        <div class="w3-margin-top">
          <img class="w3-card-8" src="<?php echo base_url('assets/img/flags/').$language->country_code; ?>.svg" alt="<?php echo $language->language.' flag.'; ?>">
        </div>

        <h3 id="<?php echo 'title_'.$language->id; ?>"><?php echo $language->language; ?></h3>

        <p>
          <?php if ($language->number_of_courses > 0): ?>
            <?php echo anchor('course/index/'.$language->id, 'Open '.$language->number_of_courses.' Courses', 'class="w3-btn-block w3-green"'); ?>
          <?php else: ?>
            <?php echo anchor('#', $language->number_of_courses.' courses available', 'class="w3-btn-block w3-disabled" style="pointer-events:none;"'); ?>
          <?php endif; ?>
        </p>
        <!-- <a class="action-link" href="<?php echo site_url('language/delete/'.$language->id); ?>" onclick="confirmDelete(event, <?php echo $language->id; ?>)">Delete</a> -->
      </div>
    </div>
    <?php endforeach; ?>
  <?php else: ?>
    <div class="w3-panel w3-card-2 w3-light-grey">
      <h3>No languages found</h3>
    </div>
  <?php endif; ?>

  <?php if (!empty($pagination)): ?>
    <div class="w3-container">
      <div class="w3-card-2 w3-padding w3-light-grey">
        <?php echo $pagination; ?>
      </div>
    </div>
  <?php endif; ?>

</div>

<script>
/*
function confirmDelete(e, language){
  var lang = document.getElementById(language).innerHTML;
  var c = confirm('Delete ' + lang + '!?\nDeleting it will delete all courses and work related to it.');
  if(c == false){ e.preventDefault(); }
}
*/
</script>
