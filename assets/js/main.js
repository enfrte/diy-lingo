function confirmDelete(e, title, affected)
{
  try {
    var title = document.getElementById(title).innerHTML;
  }
  catch(error) {
    console.log(error.message); // output the problem
    var title = ' this language '; // alternative to try
  }

  var cfm = confirm('Delete ' + title + '!?\nDeleting it will also delete all affiliated ' + affected + '.');

  if(cfm == false){ e.preventDefault(); }
}
