<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Course extends MY_Controller {

  public function __construct()
  {
    parent::__construct();
    $this->load->model('language_model');
    $this->load->model('course_model');
    $this->data['page_title'] = 'Courses';
    $this->data['page_header'] = 'Courses';
  }

  public function index($language_id = NULL)
	{
    $this->data['courses'] = $this->course_model->get_courses_by_language($language_id);
    //$this->date['course_language'] = $this->course_model->get_course_language($language_id);
    //$this->data['language_id'] = $language_id;
    //print_r($this->data['courses']);
    $language_title = $this->course_model->get_language_title($language_id); // see MY_Model
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

  // update course name
  public function update($language_id = NULL, $course_id = NULL)
  {
    $this->data['page_header'] = 'Edit course name';
    $this->data['course_title'] = $this->course_model->get_course_title($course_id);

    $validate[] = $this->course_model->validate['create_course']['course_title']; // needs to be an array of an array
    $this->form_validation->set_rules($validate);
    if($this->form_validation->run() === FALSE) {
      $this->render('course_update'); // return the user
    }
    else {
      $this->course_model->update($course_id);
      redirect('course/authored_course/', 'refresh');
    }
  }

  public function delete($course_id)
  {
    $this->course_model->delete($course_id);
    redirect('course/authored_course/', 'refresh');
  }

  // get list of user's subscribed/favourited (saved) courses 
  public function saved_courses()
  {
    $this->data['courses'] = $this->course_model->get_saved_courses();
    $this->render('course_saved');
  }

  // user can subscribe/favourite (save) course to list for quick access 
  public function save_course($language_id, $course_id)
  {
    $this->course_model->save_course($course_id);
    redirect('course/index/'.$language_id, 'refresh');
  }

  public function unsave_course($course_id)
  {
    $this->course_model->unsave_course($course_id);
    redirect('course/saved_courses/', 'refresh');
  }

  public function authored_course()
  {
    $this->data['page_header'] = 'Authored Courses';
    $this->data['courses'] = $this->course_model->get_authored_courses();
    //print_r($this->data['courses']);
    $this->render('course_authored');
  }

  // add/edit a course description
  public function update_description($course_id = NULL)
  {
    $this->data['page_header'] = 'Add/Edit description';
    $this->data['course'] = $this->course_model->get_description($course_id);
    //print_r($this->data['course']);
    $validate[] = $this->course_model->validate['create_course']['description']; // needs to be an array of an array
    $this->form_validation->set_rules($validate);
    if($this->form_validation->run() === FALSE) {
      $this->render('course_description');
    }
    else {
      $this->course_model->update_description($course_id);
      redirect('course/authored_course/', 'refresh');
    }
  }


}
