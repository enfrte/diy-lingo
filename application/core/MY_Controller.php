<?php defined('BASEPATH') OR exit('No direct script access allowed');

// a base controller for admin and public controllers.
class MY_Controller extends CI_Controller
{
  public $current_user_id = NULL;
  protected $data = array();
  
  function __construct()
  {
    parent::__construct();
    //$this->form_validation->set_error_delimiters('<div class="alert alert-danger">', '</div>'); // from form validation library
    $this->data['before_head'] = ''; // inject page specific js or styles
    $this->data['before_body'] = ''; // inject page specific js or styles
    $this->data['page_title'] = 'Set a page title!'; // browser tab title text
    $this->data['page_header'] = "Create a header"; // The big header banner on each page. You can filter where this appears in header.php
    $this->current_user_id = ( $this->ion_auth->logged_in() ? $this->ion_auth->user()->row()->id : NULL ); 
    //$this->current_user_id = $current_user_id;
    $this->securityAccess('login'); 
  }
  
  // set page templates and pass construct data when loading the view
  protected function render($the_view = NULL, $template = 'master_view')
  {
    $this->data['the_view_content'] = (is_null($the_view)) ? 'render() missing view argument' : $this->load->view($the_view, $this->data, TRUE);
    $this->load->view('templates/'.$template, $this->data);
  }
  
  // Handle the security access of the site using ion_auth library
  protected function securityAccess($access_level = NULL) {

    if($this->router->class === 'account') { return; } // not needed for the publically accessable Acount class controller methods

    if($access_level === NULL) { show_error('securityAccess requires an argument.', '', 'An Error Was Encountered'); }

    // this should be called for every controller apart from the Account controller (this is currently done in the MY_Controller construct)
    if($access_level === 'login') {
      // user accesses the login page, but is already logged in
      if(($this->router->method === 'login') && ($this->ion_auth->logged_in() === TRUE)) {
          $this->ion_auth->logout(); // log them out
          redirect('account/login', 'refresh');
      }
      // Require user to be logged in before accessing any page
      if( $this->ion_auth->logged_in() === FALSE ) {
        $this->session->set_flashdata('not_logged_in', 'You must be logged in to access that page.');
        redirect('account/login', 'refresh');
      }
    }

    // the access level requires admin, but the user is not in the admin group
    if ( $access_level === 'admin' && $this->ion_auth->in_group('admin') === FALSE ) {
      $this->ion_auth->logout();
      $this->session->set_flashdata('admin_access', 'You must be logged-in as admin to do that.');
      redirect('account/login', 'refresh');
    }
  }

  // show flash data messages 
  protected function showMessages()
  {
    $messages = NULL;
    if(!empty( $this->session->flashdata() )) { 
      foreach ($this->session->flashdata() as $key => $value) {
        // output the style (color) of the error based on whether there is a keyword in the flashdata key-name
        if (strpos($key, 'error') !== false) { 
          $messages .= '<div class="w3-panel w3-center w3-padding w3-red">'.$this->session->flashdata($key).'</div>';
        } 
        else if (strpos($key, 'success') !== false) { 
          $messages .= '<div class="w3-panel w3-center w3-padding w3-green">'.$this->session->flashdata($key).'</div>';
        } 
        else { 
          $messages .= '<div class="w3-panel w3-center w3-padding w3-blue">'.$this->session->flashdata($key).'</div>';
        } 
      }
    }
    return $messages;
  }

}

class Admin_Controller extends MY_Controller
{
  function __construct()
  {
    parent::__construct();
    $this->securityAccess('admin');
  }
  /* Not needed unless an admin view template is required
  protected function render($the_view = NULL, $template = 'master_view')
  {
    parent::render($the_view, $template);
  }
  */
}

/*
// the area accessable by logged in users
class Admin_Controller extends MY_Controller
{
  function __construct()
  {
    parent::__construct();
    // allow further site access only to those logged in, or refuse further
    // access if a session has expired
    if(!$this->ion_auth->logged_in()) { redirect('login/login', 'refresh'); }

    // user_name and group_name is used in the navbar to display the current
    // user and group menu
    if(isset($this->ion_auth->user()->row()->first_name)) $this->data['user_name'] = $this->ion_auth->user()->row()->first_name;
    if(isset($this->ion_auth->get_users_groups()->row()->name)) $this->data['group_name'] = $this->ion_auth->get_users_groups()->row()->name;

    // user is logged in. Get their details
    $this->data['current_user'] = $this->ion_auth->user()->row();
    // add the admin menu if they belong to admin or super_admin groups
    if($this->ion_auth->in_group('admin') || $this->ion_auth->in_group('super_admin'))
    {
      // load these menu items if user is an admin
      $this->data['current_user_menu'] = $this->load->view('templates/_parts/user_menu_admin_view.php', NULL, TRUE);
    }

    // Initiate the projects view with project named menu items
    $this->load->model('menu_model');
    $this->data['menu_projects'] = $this->menu_model->get_projects();
    if(isset($_SESSION['selected_project_id'])) {$this->menu_model->set_project_views();}
  }

  protected function render($the_view = NULL, $template = 'admin_master')
  {
    parent::render($the_view, $template);
  }
}

// the area accessable by the public
class Public_Controller extends MY_Controller
{
  function __construct()
  {
    parent::__construct();
    // if user is already logged in and tries to access a public class,
    // log them out before continuing
    if($this->ion_auth->logged_in()) { $this->ion_auth->logout(); }
  }

}
*/
