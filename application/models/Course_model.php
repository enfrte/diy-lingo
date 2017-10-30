<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Course_model extends MY_Model
{
  public function __construct()
  {
    parent::__construct();
  }

  public $validate = array(
    'create_course'=> array(
      'course_title' => array(
        'field'=>'course_title',
        'label'=>'Course title',
        'rules'=>'trim|required|max_length[160]'
      ),
      'select_language' => array(
        'field'=>'select_language',
        'label'=>'Select language',
        'rules'=>'trim|required|integer'
      ),
      'description' => array(
        'field'=>'description',
        'label'=>'Enter course description ',
        'rules'=>'trim|max_length[1000]'
      )
    )
  );

  public function get_courses_by_language($language_id = NULL)
  {
    $query = $this->db->query("
      SELECT
        courses.id AS id,
        courses.title AS title,
        description,
        languages.id AS language_id,
        languages.title AS language,
        (SELECT count(chapters.id) FROM chapters WHERE chapters.course_id = courses.id) AS total_chapters,
        (SELECT id FROM user_courses WHERE user_id = $this->current_user_id AND course_id = courses.id) as user_courses_id
      FROM courses
      LEFT JOIN languages
      ON courses.language_id = languages.id
      WHERE language_id = $language_id
    ");
    $courses = $query->result();
    return $courses;
  }

  // may not be using
  public function get_course_language($language_id)
  {
    $query = $this->db->query("
      SELECT
        title AS language
      FROM languages
      WHERE id = $language_id
    ");
    $course_language = $query->result();
    print_r($course_language);
    return $course_language;
  }

  public function get_courses()
  {
    $query = $this->db->query('SELECT * FROM courses');
    $courses = $query->result();
    //$courses = json_encode($query->result());
    //print_r($courses); exit;
    return $courses;
  }

  public function courses_select_dropdown()
  {
    $courses = $this->get_courses();
    $course_list = [];
    $course_list['unselected'] = "Select";
    foreach ($courses as $c) {
      $course_list[$c->id] = $c->title;
    }
    return $course_list;
  }

  public function get_course_title($id = NULL)
  {
    // pull one record from the db
    $row = $this->db->get_where('courses', array('id' => $id))->row();
    return $row->title;
  }

  // creat a course with a title
  public function create()
  {
    $language_id = $this->input->post('select_language');
    $data = array(
      'title' => $this->input->post('course_title'),
      'language_id' => $language_id,
      'user_id' => $this->current_user_id
    );
    //print_r($data); exit;
    return $this->db->insert('courses', $data);
  }

  // update the course title
  public function update($course_id)
  {
    $this->check_course_ownership($course_id);
    $data = array( 'title' => $this->input->post('course_title') );
    return $this->db->update('courses', $data, array('id' => $course_id)); // update() requires 3rd arg to be the id
  }

  public function delete($course_id)
  {
    $this->check_course_ownership($course_id);
    return $this->db->delete('courses', array('id' => $course_id));
  }

  // user can subscribe/favourite (save) course to list for quick access 
  public function save_course($course_id)
  {
    return $this->db->insert('user_courses', array('course_id'=>$course_id, 'user_id'=>$this->current_user_id));
  }

  // remove user's subscribed/favourited (saved) course from their list
  public function unsave_course($course_id)
  {
    return $this->db->delete('user_courses', array('course_id'=>$course_id, 'user_id'=>$this->current_user_id));
  }

  // get list of user's subscribed/favourited (saved) courses 
  public function get_saved_courses()
  {
    $courses = array();
    $query = $this->db->query("
    SELECT
  	user_courses.id AS user_courses_id,
      courses.id AS course_id,
      courses.title AS title,
      description,
      languages.id AS language_id,
    	languages.title AS language
    FROM user_courses
    LEFT JOIN courses
    ON user_courses.course_id = courses.id
    LEFT JOIN languages
    ON courses.language_id = languages.id
    WHERE user_courses.user_id = $this->current_user_id
    ");
    $courses = $query->result();
    //print_r($courses); exit;
    return $courses;
  }

  // get list of user's subscribed/favourited (saved) courses 
  public function get_authored_courses()
  {
    $courses = array();
    $query = $this->db->query("
    SELECT
        courses.id AS course_id,
        courses.title AS title,
        description,
    	  languages.id AS language_id,
        languages.title AS language
    FROM courses
    LEFT JOIN languages
    ON courses.language_id = languages.id
    WHERE courses.user_id = $this->current_user_id
    ");
    $courses = $query->result();
    //print_r($courses); exit;
    return $courses;
  }

  public function update_description($course_id)
  {
    $this->check_course_ownership($course_id);    
    $data = array( 'description' => $this->input->post('description') );
    return $this->db->update('courses', $data, array('id' => $course_id));
  }

  public function get_description($course_id)
  {
    $query = $this->db->query("SELECT * FROM courses WHERE id = $course_id");
    $row = $query->row();
    return array('title' => $row->title, 'description' => $row->description);
  }

}
