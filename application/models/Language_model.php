<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

// manage languages the site offers
// protected in controller methods by MY_Controller -> securityAccess method
class Language_model extends CI_Model
{
  public function __construct()
  {
    parent::__construct();
  }

  public $validate = array(
    'language'=>
      array(
        'language_name' => array(
          'field'=>'language_name',
          'label'=>'Language name',
          'rules'=>'trim|required|max_length[128]|is_unique[languages.title]'
        ),
        'country_code' => array(
          'field'=>'country_code',
          'label'=>'Country code',
          'rules'=>'trim|required|max_length[6]|is_unique[languages.country_code]'
        )
      )
  );

  public function get_languages_pagnation($limit, $offset, $search = NULL)
  {
    if( $search ) {
      $search_parameter = "WHERE languages.title LIKE '%$search%'";
    }
    else {
      $search_parameter = "";
    }

    $query = $this->db->query("
    SELECT
    	languages.id AS id,
      languages.title AS language,
      country_code,
    	COUNT(courses.id) AS number_of_courses
    FROM languages
    LEFT JOIN courses
    ON languages.id = courses.language_id
    ".$search_parameter."
    GROUP BY languages.title
    LIMIT $limit OFFSET $offset
    ");
    //print_r($query->result()); exit;
    return $query->result();
  }

  public function get_languages()
  {
    $query = $this->db->query("
    SELECT
    	languages.id AS id,
      languages.title AS language,
      country_code,
    	COUNT(courses.id) AS number_of_courses
    FROM languages
    LEFT JOIN courses
    ON languages.id = courses.language_id
    GROUP BY languages.title
    ");
    //print_r($query->result()); exit;
    return $query->result();
  }

  public function get_language_name($id = NULL)
  {
    if($id === NULL || !is_numeric($id)){ redirect('language', 'refresh'); }
    // pull one record from the db
    $row = $this->db->get_where('languages', array('id' => $id))->row();
    return $row->title;
  }

  public function create()
  {
    $data = array(
      'title' => $this->input->post('language_name'),
      'country_code' => strtolower($this->input->post('country_code')),
    );
    return $this->db->insert('languages', $data);
  }

  public function update($id = NULL)
  {
    $data = array(
      'title' => $this->input->post('language_name'),
      //'country_code' => $this->input->post('country_code'),
    );
    return $this->db->update('languages', $data, array('id' => $id)); // update() requires 3rd arg to be the id
  }

  public function delete($id = NULL)
  {
    return $this->db->delete('languages', array('id' => $id));
  }


}
