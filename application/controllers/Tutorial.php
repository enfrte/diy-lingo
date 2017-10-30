<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Tutorial extends MY_Controller {

  public function __construct()
  {
    parent::__construct();
    $this->data['page_title'] = 'Tutorial';
    $this->data['page_header'] = 'Tutorial';
    $this->load->library('parsedown');
    /*
    $this->load->model('language_model');
    $this->load->model('course_model');
    */
  }

/*
  public function index($language_id = NULL)
	{
    $this->data['courses'] = $this->course_model->get_courses_by_language($language_id);
    $this->data['language_id'] = $language_id;
    //print_r($this->data['courses']);
    $language_title = $this->course_model->get_language_title($language_id);
    $this->data['page_header'] = $language_title." courses";
		$this->render('course');
	}

  public function create()
  {
    $this->data['page_header'] = 'Create new course';
    $get_languages = $this->language_model->get_languages(); // returns $languages
    $this->data['languages'] = $get_languages;

    $validate = $this->course_model->validate['create_course']; // validation validate
    $this->form_validation->set_rules($validate); // set the validation rules
    if($this->form_validation->run() === FALSE) {
      $this->render('course_create'); // return the user
    }
    else {
      $this->course_model->create();
      redirect('course/authored_course/', 'refresh');
    }
  }
*/
/*
  public function create($language_id = NULL)
  {
    $this->data['page_header'] = 'Create new course';
    //$get_languages = $this->language_model->get_languages(); // returns $languages
    //$this->data['languages'] = $get_languages;
    $validate = $this->course_model->validate['create_course']; // validation validate
    $this->form_validation->set_rules($validate); // set the validation rules
    if($this->form_validation->run() === FALSE) {
      $this->render('course_create'); // return the user
    }
    else {
      $this->course_model->create($language_id);
      redirect('course/index/'.$language_id, 'refresh');
    }
  }
*/
  public function update($language_id = NULL, $course_id = NULL)
  {
    $this->data['page_header'] = 'Add/Edit the tutorial';
    $this->data['course_title'] = $this->course_model->get_course_title($course_id);

    $validate = $this->course_model->validate['course_update'];
    $this->form_validation->set_rules($validate);

    if($this->form_validation->run() === FALSE) {
      $this->render('course_update'); // return the user
    }
    else {
      $this->course_model->update($course_id);
      redirect('course/authored_course/', 'refresh');
    }
  }
/*
  public function delete($language_id = NULL, $course_id = NULL)
  {
    $this->course_model->delete($course_id);
    redirect('course/index/'.$language_id, 'refresh');
  }

  public function my_courses()
  {
    $this->data['courses'] = $this->course_model->get_my_courses();
    $this->render('course_mycourse');
  }

  public function save_course($language_id = NULL, $course_id = NULL)
  {
    $this->course_model->save_course($course_id);
    redirect('course/index/'.$language_id, 'refresh');
  }

  public function unsave_course($course_id = NULL)
  {
    $this->course_model->unsave_course($course_id);
    redirect('course/my_courses/', 'refresh');
  }

  public function authored_course()
  {
    $this->data['courses'] = $this->course_model->get_authored_courses();
    $this->render('course_authored');
  }
*/

}
