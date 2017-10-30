<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Language extends MY_Controller {

  public function __construct()
  {
    parent::__construct();
    $this->load->model('language_model');
    $this->data['page_title'] = 'Languages';
    $this->data['page_header'] = 'Languages';
  }

  public function read()
	{
    $this->load->library('pagination');
    $offset = 0;
    $config['base_url'] = base_url("language/read");
    $config['per_page'] = 3; // sql query LIMIT number
    //echo "Segment three: ".$this->uri->segment(3);
    $offset = ( $this->uri->segment(3) ? $this->uri->segment(3) : 0 );

    /*if( $this->input->post('search') ) {
      // user actually enters something into the input field
      $search = $this->input->post('search');
    }
    elseif( $this->input->get('search') ) {
      $search = $this->input->get('search');
      // user clicks a link with a query, and the query property has a value
    }*/
    // set search
    if( $this->input->post('search') || $this->input->get('search') ) {
      $search = ( $this->input->post('search') ? $this->input->post('search') : $this->input->get('search') );
    }
    else {
      // user has hit return in an empty input field, or has clicked a query link with no property value
      $search = NULL;
    }

    $config['suffix'] = "?search=$search"; // attaches a query onto $this->uri->segment(3), aka $offset

    // user searches while offset is out of range of search result
    if( $offset != 0 && $this->input->post('search') ){
      redirect("language/read/0?search=$search");
    }
    // user searches via input while no GET query is in URL
    if( $offset != 0 && $this->input->get('search') === NULL ){
      redirect("language/read/0?search=$search");
    }

    $this->data['languages'] = $this->language_model->get_languages_pagnation($config['per_page'], $offset, $search);
    $config['total_rows'] = $this->db->query("SELECT id FROM languages WHERE title LIKE '%$search%'")->num_rows();
    $config['first_url'] = "0?search=$search"; // explicitly set this to the first link

    $this->pagination->initialize($config);
    $this->data['pagination'] = $this->pagination->create_links();
    //print_r($this->data['languages']);
		$this->render('language');
	}

  public function create()
  {
    $this->securityAccess('admin');
    $this->data['before_body'] = '<script src="'. base_url('assets/js/flag-dataset.js').'" charset="utf-8"></script>'."\n".'<script src="'. base_url("assets/js/flag-picker.js") .'" charset="utf-8"></script>'."\n";
    $this->data['page_header'] = 'Create new language';

    $validate = $this->language_model->validate['language']; // validation validate
    $this->form_validation->set_rules($validate); // set the validation rules
    // validate form submission or form has loaded for the first time
    if($this->form_validation->run() === FALSE) {
      $this->render('language_create'); // return the user
    }
    else {
      $this->language_model->create();
      redirect('language/read/', 'refresh');
    }
  }

  public function update($id = NULL)
  {
    $this->securityAccess('admin');
    $this->data['page_header'] = 'Edit language name';
    $this->form_validation->set_rules('language_name', 'Language name', 'trim|required|max_length[128]|is_unique[languages.title]');

    if($this->form_validation->run() === FALSE) {
      $this->data['language_name'] = $this->language_model->get_language_name($id);
      $this->render('language_update'); // return the user
    }
    else {
      $this->language_model->update($id);
      redirect('language/read/', 'refresh');
    }
  }

  public function delete($id = NULL)
  {
    $this->securityAccess('admin');
    $this->language_model->delete($id);
    redirect('language/read/', 'refresh');
  }

/*  public function pagination($db_query, $limit)
  {
    // see config for pagination default values
    $config['base_url'] = '/language/read/';
    $config['total_rows'] = count($db_query);
    $config['per_page'] = $limit; // sql query LIMIT number

    $this->pagination->initialize($config);
    echo $this->pagination->create_links();
  }
*/

}
