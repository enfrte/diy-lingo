<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Account_model extends CI_Model
{
  public function __construct()
  {
    parent::__construct();
  }

  public $validate = array(
    'account'=>
      array(
        'login' => array(
          'field'=>'login',
          'label'=>'Email field',
          'rules'=>'trim|valid_email|required|max_length[256]|is_unique[users.email]'
        ),
        'password' => array(
          'field'=>'password',
          'label'=>'Password ',
          'rules'=>'trim|required|min_length[8]'
        )
      )
  );


  // setup the admin account
  public function check_activation_required()
  {
    $query = $this->db->query('SELECT * FROM users');
    // check for no accounts
    if(empty($query->result())){
      return TRUE;
    }
    else {
      $this->session->set_flashdata('message', 'An admin account has already been activated. Please login.');
      return FALSE;
    }

  }

  public function setup_admin_account()
  {
    $login = $this->input->post('login');
    $password = $this->input->post('password');

    // create an admin group
    $create_admin_group = $this->ion_auth->create_group('admin', 'The administration group');
    // while we are here, let's also create the members group
    $create_members_group = $this->ion_auth->create_group('members', 'The members group');
    if(!$create_admin_group || !$create_members_group) {
      // the following runs if a group called admin already exists
      // error: Group name already taken - but code execution can still run.
      // If some other error happens, then this is useful for when register() fails because there is no user group
      $this->session->set_flashdata('message', $this->ion_auth->errors());
    }

    $admin_group = NULL;
    $group_query = $this->ion_auth->groups()->result();
    //print_r($group_query);
    foreach($group_query as $struct) {
      if ($struct->name == 'admin') {
        $admin_group = $struct->id;
        break;
      }
    }
    if(is_null($admin_group)){
      $this->session->set_flashdata('message', 'Could not create group or find admin group id.');
      return;
    }

    /*
      Register (create) a new user.
      Parameters:
      1. 'Identity' - string REQUIRED. This must be the value that uniquely identifies the user when he is registered. If you chose "email" as $config['identity'] in the configuration file, you must put the email of the new user.
      2. 'Password' - string REQUIRED.
      3. 'Email' - string REQUIRED.
      4. 'Additional Data' - multidimensional array OPTIONAL.
      5. 'Group' - array OPTIONAL. If not passed the default group name set in the config will be used.
    */
    if ($this->ion_auth->register($login, $password, $login, NULL, array($admin_group) )) {
      $this->session->set_flashdata('account_created_success', $this->ion_auth->messages());
    }
    else {
      $this->session->set_flashdata('error_message', $this->ion_auth->errors());
    }

  }

  // create new user (user registration)
  public function setup_user_account()
  {    
    $login = $this->input->post('login');
    $password = $this->input->post('password');

    $member_group = NULL;
    $group_query = $this->ion_auth->groups()->result();
    //print_r($group_query);exit;
    foreach($group_query as $struct) {
      if ($struct->name == 'members') {
        $member_group = $struct->id;
        break;
      }
    }
    if(is_null($member_group)){
      $this->session->set_flashdata('no_group_id_error', 'Could not create group or find member group id.');
      return;
    }

    /*
      Register (create) a new user.
      Parameters:
      1. 'Identity' - string REQUIRED. This must be the value that uniquely identifies the user when he is registered. If you chose "email" as $config['identity'] in the configuration file, you must put the email of the new user.
      2. 'Password' - string REQUIRED.
      3. 'Email' - string REQUIRED.
      4. 'Additional Data' - multidimensional array OPTIONAL.
      5. 'Group' - array OPTIONAL. If not passed the default group name set in the config will be used.
    */
    if ($this->ion_auth->register($login, $password, $login, NULL, array($member_group) )) {
      $this->session->set_flashdata('account_created_success', $this->ion_auth->messages());
    }
    else {
      $this->session->set_flashdata('register_user_error', $this->ion_auth->errors());
    }
  }

}
