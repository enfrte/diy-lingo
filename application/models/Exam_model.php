<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Exam_model extends CI_Model
{
  public function __construct()
  {
    parent::__construct();
  }

public function select_test()
{
  // get all languages, courses, chapters
  $query = $this->db->query('
  SELECT
    languages.id as language_id,
    languages.language as language_name,
    courses.id as course_id,
    courses.title as course_title,
    chapters.id as chapter_id,
    chapters.title as chapter_title
  FROM languages
  LEFT JOIN courses
  ON languages.id = courses.language_id
  LEFT JOIN chapters
  ON courses.id = chapters.course_id
  ');
  $query_result = $query->result();
  //print_r($query_result); exit;
  $select_test_data = array();

  foreach ($query_result as $result) {
    $select_test_data[$result->chapter_id]['language_id'] = $result->language_id;
    $select_test_data[$result->chapter_id]['language_name'] = $result->language_name;
    $select_test_data[$result->chapter_id]['course_id'] = $result->course_id;
    $select_test_data[$result->chapter_id]['course_title'] = $result->course_title;
    $select_test_data[$result->chapter_id]['chapter_id'] = $result->chapter_id;
    $select_test_data[$result->chapter_id]['chapter_title'] = $result->chapter_title;
  }
  //print_r($query_result);
  //print_r($select_test_data); exit;
  return $select_test_data;
}

  public function get_exam_data($chapter_id)
  {
    $query = $this->db->query("SELECT * FROM sentences WHERE chapter_id = $chapter_id");
    $server_data = array();

    foreach ($query->result() as $row)
    {
      $staged_sentence = explode(" ", $row->translated_sentence);
      $extra_stage_data = ["punainen", "kissa"];
      $staged_sentence = array_merge($staged_sentence, $extra_stage_data);
      shuffle($staged_sentence);

      array_push($server_data, [
        $row->source_sentence,
        $row->translated_sentence,
        $staged_sentence
      ]);
    }

    $server_data = json_encode($server_data);
    //print_r($server_data); exit;
    //$query = $this->db->get_where('news', array('slug' => $slug));
    //return $query->row_array();
    return $server_data;
  }

}
