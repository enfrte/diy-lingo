<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Chapter_model extends MY_Model
{
  public function __construct()
  {
    parent::__construct();
  }

  public $validate = array(
    'chapter_create'=> array(
      'chapter_name' => array(
        'field'=>'chapter_name',
        'label'=>'chapter name',
        'rules'=>'trim|required|max_length[160]'
      ),
      /*
      'select_course' => array(
        'field'=>'select_course',
        'label'=>'Select course',
        'rules'=>'trim|required|integer'
      ) */
    ),
    'chapter_update' => array(
      'chapter_title' => array(
        'field'=>'chapter_title',
        'label'=>'chapter name',
        'rules'=>'trim|required|max_length[160]'
      )
    ),
    'chapter_tutorial' => array(
      'tutorial_body' => array(
        'field'=>'tutorial',
        'label'=>'tutorial body',
        'rules'=>'trim|max_length[21843]'
      )
    )

  );

  public function get_course_owner($course_id = NULL)
  {
    //$query = $this->db->query("SELECT user_id AS owner FROM courses WHERE id = $course_id");
    $this->db->select('user_id AS owner');
    $this->db->from('courses');
    $this->db->where('id', $course_id);
    $query = $this->db->get();
    // can be empty (perhaps db column should return NULL if nothing matches?)
    /*
    if(!empty($query->row()->owner)) {
      $course_owner = $query->row()->owner;
    }
    else {
      $course_owner = NULL; // no owner because no courses have been created yet
    }
    */
    return $query->row()->owner;
  }

  public function get_chapters_by_course($course_id)
  {
    // https://arjunphp.com/how-to-write-subqueries-in-codeigniter-active-record/
    $course_id = (int)$course_id;
    // select course chapters and count number of sentences in each chapter
    $query = $this->db->query("
    SELECT
    	chapters.id AS id,
    	chapters.chapter_order AS chapter_order,
    	chapters.title AS title,
    	chapters.description AS description,
    	length(chapters.tutorial_html) AS tutorial_length,
    	chapters.course_id AS course_id,
      (SELECT count(sentences.id) FROM sentences WHERE sentences.chapter_id = chapters.id) AS total_sentences,
      (SELECT user_id FROM courses WHERE id = $course_id ) AS course_owner
    FROM chapters
    WHERE chapters.course_id = $course_id
    ");

    /*
    foreach ($chapters as $key => $value) {
      // query the query, and push the result as a new array property
      $query = $this->db->query("SELECT count(id) AS total_sentences FROM sentences WHERE chapter_id = $value->id");
      $chapters[$key]->total_sentences = $query->row()->total_sentences;
    }
    */
    return $query->result();
  }

  public function get_course_data($course_id)
  {
    //$query = $this->db->query("SELECT title AS course_title FROM courses WHERE id = $course_id");
    //return $query->row()->course_title;
    // pull one record from the db
    $row = $this->db->get_where('courses', array('id' => $course_id))->row();
    return $row;
  }

  public function get_chapters()
  {
    $query = $this->db->query('SELECT * FROM chapters');
    $chapters = $query->result();
    //$chapters = json_encode($query->result());
    return $chapters;
  }

  public function get_chapter_title($id = NULL)
  {
    // pull one record from the db
    $row = $this->db->get_where('chapters', array('id' => $id))->row();
    return $row->title;
  }

  public function create($course_id)
  {
    $this->check_course_ownership($course_id);
    //$course_id = $this->input->post('select_course');
    $data = array(
      'title' => $this->input->post('chapter_name'),
      'course_id' => $course_id,
    );
    return $this->db->insert('chapters', $data);
  }

  public function update($course_id, $chapter_id)
  {
    $this->check_course_ownership($course_id);    
    $data = array( 'title' => $this->input->post('chapter_title') );
    return $this->db->update('chapters', $data, array('id' => $chapter_id)); // update() requires 3rd arg to be the id
  }

  public function delete($course_id, $chapter_id)
  {
    $this->check_course_ownership($course_id);
    return $this->db->delete('chapters', array('id' => $chapter_id));
  }

  // get the chapter tutorial text (for editing, or display)
  public function get_chapter_tutorial($chapter_id, $markup)
  {
    $markup = ($markup === 'html') ? 'tutorial_html' : 'tutorial_markdown' ;
    $chapter_id = (int)$chapter_id;
    $query = $this->db->query("SELECT title, $markup, course_id FROM chapters WHERE id = $chapter_id");
    $row = $query->row();
    return  array('title' => $row->title, 'tutorial' => $row->$markup, 'course_id' => $row->course_id);
  }

  // update the chapter tutorial 
  public function set_chapter_tutorial($course_id, $chapter_id)
  {
    $this->check_course_ownership($course_id);    
    // perform an update to the row
    $this->load->library('parsedown');
    // Markdown should be cleaned if the admin can be exposed to it
    $markdown = strip_tags($this->input->post('tutorial'));
    $html = $this->parsedown->text($markdown); // markdown2html

    $data = array( 'tutorial_markdown' => $markdown, 'tutorial_html' => $html );
    return $this->db->update('chapters', $data, array('id' => $chapter_id));
  }


  // perhaps not needed anymore
  /*public function chapters_select_dropdown()
  {
    $chapters = $this->get_chapters();
    $chapter_list = [];
    $chapter_list['unselected'] = "Select";
    foreach ($chapters as $c) {
      $chapter_list[$c->id] = $c->title;
    }
    return $chapter_list;
  }
  */

}
