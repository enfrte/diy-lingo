<?php defined('BASEPATH') OR exit('No direct script access allowed');

// handles account logic. Note, securityAccess method skips this class 
class Account extends MY_Controller
{
  function __construct()
  {
    parent::__construct();
    $this->load->model('account_model');
    $this->data['page_title'] = 'Login';
    $this->data['page_header'] = 'Accounts';
    $this->data['showMessages'] = $this->showMessages();    
  }

  public function index() { }

  public function login()
  {
    $this->data['page_header'] = 'Login';
    // in case the root domain is entered and the user is already logged in, this will prevent the login screen appearing in the view
    //if($this->ion_auth->logged_in()) { redirect('', 'refresh'); }

    // user attemps to log in
    if($this->input->post())
    {
      $this->form_validation->set_rules('login', 'Identity', 'required|valid_email');
      $this->form_validation->set_rules('password', 'Password', 'required');
      $this->form_validation->set_rules('remember','Remember me','integer');
      
      if($this->form_validation->run()===TRUE)
      {
        $remember = (bool) $this->input->post('remember'); // remember me checkbox
        if ($this->ion_auth->login($this->input->post('login'), $this->input->post('password'), $remember)) {
          redirect($this->router->default_controller, 'refresh'); // the default route set in routes
        }
        else {
          $this->session->set_flashdata('message', $this->ion_auth->errors());
          redirect('account/login/', 'refresh');
        }
      }
    }
    // display default login page
    $this->render('login');
  }

  public function logout()
  {
    $this->ion_auth->logout();
    redirect('account/login', 'refresh');
  }

  // create the first user
  public function setup()
  {
    if($this->account_model->check_activation_required() === FALSE) {
      redirect('account/login', 'refresh');
    }

    $validate = $this->account_model->validate['account']; // validation
    $this->form_validation->set_rules($validate); // set the validation rules
    // validate form submission or form has loaded for the first time
    if($this->form_validation->run() === FALSE) {
      $this->render('account_setup'); // return the user
    }
    else {
      $this->account_model->setup_admin_account();
      redirect('account/login', 'refresh');
    }
  }

  // create a new user (user registration)
  public function create()
  {
    $this->data['page_header'] = 'Register';    
    $validate = $this->account_model->validate['account']; 
    $this->form_validation->set_rules($validate); 
    
    if($this->form_validation->run() === FALSE) {
      $this->render('account_registration'); // return the user
    }
    else {
      $this->account_model->setup_user_account();
      redirect('account/login', 'refresh');
    }
    
  }
}
