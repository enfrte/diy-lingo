<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Sentence extends MY_Controller {

  public function __construct()
  {
    parent::__construct();
    $this->load->model('chapter_model');
    $this->load->model('sentence_model');
    $this->data['page_title'] = 'Sentences';
    $this->data['page_header'] = 'Sentences';
  }

	public function index($course_id, $chapter_id)
	{
    $this->data['sentences'] = $this->sentence_model->get_sentences_by_chapter($chapter_id);
    $this->data['chapter_id'] = $chapter_id;
    $this->data['course_id'] = $course_id;
    //print_r($this->data['sentences']);
    $this->render('sentence');
	}

  public function create($chapter_id = NULL)
  {
    $this->data['page_header'] = 'Create new sentence';
    //print_r($this->input->post());exit; // check post variables
    //$this->data['chapters'] = $this->chapter_model->get_chapters(); // for select dropdown
    //$this->data['chapters_select_dropdown'] = $this->chapter_model->chapters_select_dropdown();

    $validate = $this->sentence_model->validate['sentence_fields'];
    $this->form_validation->set_rules($validate);
    if($this->form_validation->run() === FALSE) {
      $this->render('sentence_create');
    }
    else {
      $this->sentence_model->create($chapter_id);
      redirect('sentence/index/'.$chapter_id, 'refresh');
    }
  }

	public function create_batch($course_id, $chapter_id)
  {
    $this->data['page_header'] = 'Create new sentence';

		$this->form_validation->set_rules('textarea_batch', 'Batch upload', 'required');
    if($this->form_validation->run() === FALSE) {
      $this->render('sentence_create_batch');
    }
    else {
      $this->sentence_model->create_batch($chapter_id);
      redirect('sentence/index/'.$course_id.'/'.$chapter_id, 'refresh');
    }
  }


  public function update($course_id, $chapter_id, $sentence_id)
  { 
    $this->data['page_header'] = 'Edit sentences';
    $this->data['sentence'] = $this->sentence_model->get_sentence($sentence_id);
    $validate = $this->sentence_model->validate['sentence_fields'];
    unset($validate['select_chapter']); // select_chapter not needed
    $this->form_validation->set_rules($validate);
    //print_r($this->data['sentence']);

    if($this->form_validation->run() === FALSE) {
      $this->render('sentence_update');
    }
    else {
      $this->sentence_model->update($chapter_id, $sentence_id);
      redirect("sentence/index/$course_id/$chapter_id", 'refresh');
    }
  }

  public function delete($course_id, $chapter_id, $sentence_id)
  {
    $this->sentence_model->delete($chapter_id, $sentence_id);
    redirect("sentence/index/$course_id/$chapter_id", 'refresh');
  }

  public function practice($chapter_id)
  {
    $this->data['page_header'] = 'Practice';
    $this->data['before_head'] = '<link rel="stylesheet" type="text/css" href="' . base_url('assets/css/modal.css') . '">';
    // xss cleaning is done at the model since this is json data to be used by vueJS
    $this->data['practice_sentences'] = $this->sentence_model->get_practice_sentences($chapter_id);
    $this->render('sentence_practice');
  }

}
