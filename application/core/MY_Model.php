<?php defined('BASEPATH') OR exit('No direct script access allowed');

// a base controller for admin and public controllers.
class MY_Model extends CI_Model
{
  protected $data = array();
  private $current_user_id;

  function __construct()
  {
    parent::__construct();
    $this->current_user_id = ( $this->ion_auth->logged_in() ? $this->ion_auth->user()->row()->id : NULL );
  }

  public function get_language_title($language_id = NULL)
  {
    $row = $this->db->get_where('languages', array('id' => $language_id))->row();
    return $row->title;
  }

  // check if the current user owns the content they are trying to modify
  protected function check_course_ownership($course_id = NULL)
  {
    $this->db->select('courses.user_id');
    $this->db->from('courses');
    $this->db->where('courses.id', $course_id);
    $course_owner_id = $this->db->get()->row()->user_id;
    // check current user match
    if($this->current_user_id !== $course_owner_id) { 
      $this->session->set_flashdata('ownership_error', 'Error: System has detected you are not the content owner.');
      $this->ion_auth->logout();      
      redirect('account/login', 'refresh'); // serious offence: kick out user
    }
    return; // do nothing if all looks ok
  }

  // check if the current user owns the content they are trying to modify
  protected function check_chapter_ownership($chapter_id = NULL)
  {
    $this->db->select('courses.user_id');
    $this->db->from('chapters');
    $this->db->join('courses', 'chapters.course_id = courses.id', 'left');
    $this->db->where('chapters.id', $chapter_id);
    $course_owner_id = $this->db->get()->row()->user_id;
    // check current user match
    if($this->current_user_id !== $course_owner_id) { 
      $this->session->set_flashdata('ownership_error', 'Error: System has detected you are not the content owner.');
      $this->ion_auth->logout();      
      redirect('account/login', 'refresh'); // serious offence: kick out user
    }
    return; // do nothing if all looks ok
  }

  // protect method from non admin access 
  /* Replaced by MY_Controller -> securityAccess()
  protected function check_is_admin()
  {
    if ( $this->ion_auth->in_group('admin') === FALSE ) {
      $this->session->set_flashdata('ownership_error', 'Error: System has detected you are not the content owner.');
      $this->ion_auth->logout();
      redirect('account/login', 'refresh');
    }
  }
  */
}
