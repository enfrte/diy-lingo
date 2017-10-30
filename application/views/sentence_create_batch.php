<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<div id="container" class="container" style="max-width:768px;">
  <!-- http://wordpress.stackexchange.com/questions/72941/avoid-converting-to-gt -->
  <div class="w3-panel w3-padding-bottom w3-card-2 w3-light-grey">
    <p>Enter or copy and paste sentences into this textarea. Entries are seperated by newlines. Divide source, translated, and alternative translations sentences by tabs.</p>
  </div>

  <div class="w3-panel w3-card-2 w3-light-grey w3-padding-top">
  <?php
    echo form_open('',array('role'=>'form'));

    echo form_label('Enter sentences ', 'textarea_batch');
    echo form_error('textarea_batch');
    echo form_textarea('textarea_batch', set_value('', ''), array('id' => 'textarea_batch', 'style' => 'width:100%;height:200px;white-space:nowrap;overflow:auto;', 'class'=>'w3-input w3-border', 'placeholder' => 'Supports tabs'));

    echo form_submit('submit', 'Submit', 'class="w3-btn-block w3-green w3-section w3-padding"');
    echo form_close();
  ?>
  </div>
</div>

<script>

(function allow_textarea_tabs(){
var textareas = document.getElementsByTagName('textarea');
var count = textareas.length;
for(var i=0;i<count;i++){
    textareas[i].onkeydown = function(e){
        if(e.keyCode==9 || e.which==9){
            e.preventDefault();
            var s = this.selectionStart;
            this.value = this.value.substring(0,this.selectionStart) + "\t" + this.value.substring(this.selectionEnd);
            this.selectionEnd = s+1;
        }
    }
}
})();

</script>
