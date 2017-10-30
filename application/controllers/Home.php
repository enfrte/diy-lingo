<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends MY_Controller {

  public function __construct()
  {
    parent::__construct();
    $this->data['page_title'] = 'Home';
    $this->data['page_header'] = 'DIY Lingo';
  }

	public function index()
	{
    //$this->data['languages'] = $this->language_model->get_languages();
    //print_r($this->data['languages']);
		$this->render('home');
	}

}
