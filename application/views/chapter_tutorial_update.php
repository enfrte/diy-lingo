<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<div id="container" class="container" style="max-width:768px;">
  <!-- http://wordpress.stackexchange.com/questions/72941/avoid-converting-to-gt -->
  <div class="w3-panel w3-padding-bottom w3-card-2 w3-light-grey">
    <p>You can format your tutorial using the <a href="https://en.wikipedia.org/wiki/Markdown">Markdown syntax</a>. Any HTML tags you enter will stripped. For more advanced syntax options or more detailed instructions, see the <a href="http://daringfireball.net/projects/markdown/syntax" rel="nofollow"> Official Markdown Syntax</a>.</p>
    <a href="#" onclick="diylingo_accordion('diylingo_accordion_markdown_help')">For now, click here for a quick reference table:</a>
    <div id="diylingo_accordion_markdown_help" class="w3-white w3-section w3-hide w3-animate-zoom">
      <table class="w3-table-all">
        <tbody>
        <tr>
          <th>You type:</th>
          <th>You see:</th></tr>
        <tr>
          <td>## Header 2</td>
          <td><h2>Header 2</h2></td></tr>
        <tr>
          <td><code>*italics*</code></td>
          <td><em>italics</em></td></tr>
        <tr>
          <td><code>**bold**</code></td>
          <td><strong>bold</strong></td></tr>
        <tr>
          <td>* item 1<br>* item 2<br>* item 3</td>
          <td><ul><li>item 1</li><li>item 2</li><li>item 3</li></ul></td></tr>
        <tr>
          <td><code>~~strikethrough~~</code></td>
          <td><del>strikethrough</del></td></tr>
        <tr>
          <td><code>[DIY Lingo](<?php echo base_url(); ?>)</code></td>
          <td><a href="<?php echo site_url(); ?>" rel="nofollow">DIY Lingo</a></td></tr>
        <tr>
          <td><code>![Optional alt text](<?php echo site_url(); ?>favicon.ico)</code></td>
          <td><img src="<?php echo site_url(); ?>favicon.ico" alt="Hammer logo" height="90" width="90"></td></tr>
        <tr>
          <td><code>(4 spaces)preformatted text</code><br><em>Requires a blank line between the preformatted text and any normal text above.</em></td>
          <td><code>preformatted text</code></td></tr>
        <tr>
          <td>blah blah `inline preformatted text` blah blah</td>
          <td>blah blah <code>inline code text</code> blah blah</td></tr>
        <tr>
          <td>&nbsp;> A block-quote quote</td>
          <td><blockquote><p>A block-quote quote</p></blockquote></td>
        </tr>
        </tbody>
      </table>
    </div>
  </div>

  <?php echo validation_errors(); ?>
  <div class="w3-panel w3-card-2 w3-light-grey w3-padding-top">
  <?php
    echo form_open('',array('role'=>'form'));

    echo form_label('Enter course tutorial for '.$chapter_tutorial['title'].' ', 'tutorial');
    echo form_error('tutorial');
    echo form_textarea('tutorial', set_value('tutorial', $chapter_tutorial['tutorial']), array('id' => 'tutorial', 'style' => 'width:100%;height:200px;', 'class'=>'w3-input w3-border', 'placeholder' => 'MarkDown supported text'));

    echo form_submit('submit', 'Submit', 'class="w3-btn-block w3-green w3-section w3-padding"');
    echo form_close();
  ?>
  </div>
</div>

<script>

(function decode_blockquote_symbol(){
  // allow blockquote greater than tag to display in textarea
  var textarea = document.getElementById("tutorial");
  var textarea_contents = document.getElementById("tutorial").value;
  textarea.innerHTML = textarea_contents.replace(/&gt;/, '>');
})();

function diylingo_accordion(id) {
    var x = document.getElementById(id);
    if (x.className.indexOf("w3-show") == -1) {
        x.className += " w3-show";
    } else {
        x.className = x.className.replace(" w3-show", "");
    }
}
</script>
