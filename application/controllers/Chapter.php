<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Chapter extends MY_Controller {

  public function __construct()
  {
    parent::__construct();
    $this->load->model('chapter_model');
    //$this->load->model('course_model');
    $this->data['page_title'] = 'Chapters';
    $this->data['page_header'] = 'Chapters';
  }

	public function index($course_id = NULL)
	{
    $this->data['chapters'] = $this->chapter_model->get_chapters_by_course($course_id);
    $this->data['course_data'] = $this->chapter_model->get_course_data($course_id);
    //print_r($this->data['course_data']);
    /*
      haven't figured out whether it's better to use a separate
      get_course_owner. On one hand, it's used in the Add chapters button, but
      in the future, it may come in handy when groups are associated with
      courses. It then may change to get_course_owner_group.
    */
    $this->data['course_owner'] = $this->chapter_model->get_course_owner($course_id);
    $this->data['course_id'] = $course_id;
    $this->render('chapter');
	}

  /*
    authored_chapter and index are pretty much the same, but I wanted to
    identify where the user was coming from with
    $this->router->fetch_method() === '???' so I could determin whether or
    not to show the author menu when the course view was rendered. It's a
    bit of a hack and I will change the functionality when I figure a better
    way of doing it.
  */
  public function authored_chapter($course_id = NULL)
	{
    $this->data['page_header'] = 'Authored chapters';
    $this->data['chapters'] = $this->chapter_model->get_chapters_by_course($course_id);
    $this->data['course_data'] = $this->chapter_model->get_course_data($course_id);
    // move course_owner to chapters query
    $this->data['course_owner'] = $this->chapter_model->get_course_owner($course_id);
    $this->data['course_id'] = $course_id;
    $this->render('chapter');
	}

  // new chapter
  public function create($course_id = NULL)
  {
    $this->data['page_header'] = 'Create new chapter';
    //$this->data['courses'] = $this->course_model->get_courses();
    //$this->data['courses_select_dropdown'] = $this->course_model->courses_select_dropdown();
    $validate = $this->chapter_model->validate['chapter_create'];
    $this->form_validation->set_rules($validate);
    if($this->form_validation->run() === FALSE) {
      $this->render('chapter_create');
    }
    else {
      $this->chapter_model->create($course_id);
      redirect('chapter/authored_chapter/'.$course_id, 'refresh');
    }
  }

  // update chapter title
  public function update($course_id = NULL, $chapter_id = NULL)
  {
    $this->data['page_header'] = 'Chapter update';
    $validate = $this->chapter_model->validate['chapter_update'];
    $this->form_validation->set_rules($validate);

    if($this->form_validation->run() === FALSE) {
      $this->data['chapter_title'] = $this->chapter_model->get_chapter_title($chapter_id);
      $this->render('chapter_update'); // return the user
    }
    else {
      $this->chapter_model->update($course_id, $chapter_id);
      redirect('chapter/authored_chapter/'.$course_id, 'refresh');
    }
  }

  public function delete($course_id = NULL, $chapter_id = NULL)
  {
    $this->chapter_model->delete($course_id, $chapter_id);
    redirect('chapter/authored_chapter/'.$course_id, 'refresh');
  }

  // edit the tutorial as an author
  public function tutorial_update($course_id = NULL, $chapter_id = NULL)
  {
    $this->data['page_header'] = 'Chapter tutorial';

    $validate = $this->chapter_model->validate['chapter_tutorial'];
    $this->form_validation->set_rules($validate);
    if($this->form_validation->run() === FALSE) {
      $this->data['chapter_tutorial'] = $this->chapter_model->get_chapter_tutorial($chapter_id, 'markdown');
      //print_r($this->data['chapter_tutorial']);
      $this->render('chapter_tutorial_update');
    }
    else {
      $this->chapter_model->set_chapter_tutorial($course_id, $chapter_id);
      redirect('chapter/authored_chapter/'.$course_id, 'refresh');
    }
  }

  // read the tutorial as a user
  public function tutorial_read($chapter_id = NULL)
  {
    $this->data['page_header'] = 'Chapter tutorial';
    $this->data['chapter_tutorial'] = $this->chapter_model->get_chapter_tutorial($chapter_id, 'html');
    $this->data['chapter_id'] = $chapter_id; 
    $this->render('chapter_tutorial');
  }


}
