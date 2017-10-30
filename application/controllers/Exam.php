<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Exam extends MY_Controller {

  public function __construct()
  {
    parent::__construct();
    $this->load->model('exam_model');
    $this->load->model('language_model');
  }

	public function index()
	{
    $this->data['select_test'] = $this->exam_model->select_test();
    //print_r($this->data['select_test']);
		$this->render('exam');
	}

  public function take_exam($chapter_id = NULL)
  {
    $this->data['server_data'] = $this->exam_model->get_exam_data($chapter_id);
		$this->render('exam_take');
  }

}
