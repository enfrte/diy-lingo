<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Sentence_model extends MY_Model
{
  public function __construct()
  {
    parent::__construct();
  }

  public $validate = array(
    'sentence_fields'=> array(
      /*
      'select_chapter' => array(
        'field'=>'select_chapter',
        'label'=>'Select chapter',
        'rules'=>'required|integer'
      ),
      */
      'source_sentence' => array(
        'field'=>'source_sentence',
        'label'=>'Source',
        'rules'=>'trim|required|max_length[500]'
      ),
      'translated_sentence' => array(
        'field'=>'translated_sentence',
        'label'=>'Translation',
        'rules'=>'trim|required|max_length[500]'
      ),
      'alt_translated_sentence' => array(
        'field'=>'alt_translated_sentence[]',
        'label'=>'Select alternative translation',
        'rules'=>'trim|max_length[500]'
      )
    )
  );

  public function get_sentences_by_chapter($chapter_id)
  {
    $query = $this->db->query("
      SELECT
      	sentences.id as id,
      	source_sentence,
        sentences.translated_sentence,
        difficulty,
        alt_translations.id as alt_translation_id,
        alt_translations.translated_sentence as alt_translated_sentence
      FROM sentences
      LEFT JOIN alt_translations
      ON sentences.id = alt_translations.sentence_id
      WHERE sentences.chapter_id = $chapter_id
    ");

    $query_result = $query->result();
    $sentences = array();
    foreach ($query_result as $result) {
      $sentences[$result->id]['id'] = $result->id;
      $sentences[$result->id]['source_sentence'] = $result->source_sentence;
      $sentences[$result->id]['translated_sentence'] = $result->translated_sentence;
      $sentences[$result->id]['difficulty'] = $result->difficulty;
      $sentences[$result->id]['alt_translations'][] = array(
        'alt_translation_id' => $result->alt_translation_id,
        'alt_translated_sentence' => $result->alt_translated_sentence
      );
    }
    //print_r($sentences);
    //exit;
    return $sentences;
  }

  // used for create_sentence
  public function get_sentences()
  {
    /*
    $this->db->select('*');
    $this->db->from('sentences');
    $this->db->join('alt_translations', 'alt_translations.sentence_id = sentences.id', 'left');
    $query = $this->db->get();
    $sentences = $query->result();
    */
    $query = $this->db->query('
      SELECT
      	sentences.id as id,
      	source_sentence,
        sentences.translated_sentence,
        difficulty,
        alt_translations.id as alt_translation_id,
        alt_translations.translated_sentence as alt_translated_sentence
      FROM sentences
      LEFT JOIN alt_translations
      ON sentences.id = alt_translations.sentence_id
    ');

    $query_result = $query->result();
    $sentences = array();
    foreach ($query_result as $result) {
      $sentences[$result->id]['id'] = $result->id;
      $sentences[$result->id]['source_sentence'] = $result->source_sentence;
      $sentences[$result->id]['translated_sentence'] = $result->translated_sentence;
      $sentences[$result->id]['difficulty'] = $result->difficulty;
      $sentences[$result->id]['alt_translations'][] = array(
        'alt_translation_id' => $result->alt_translation_id,
        'alt_translated_sentence' => $result->alt_translated_sentence
      );
    }
    //print_r($sentences);
    //exit;
    return $sentences;
  }

  // used for update_sentence
  public function get_sentence($id = NULL)
  {
    $sentence = $this->get_sentences();
    return $sentence[$id];
  }

  public function get_chapter_title($id = NULL)
  {
    // pull one record from the db
    $row = $this->db->get_where('chapters', array('id' => $id))->row();
    return $row->title;
  }

  // single sentence/entry creation 
  public function create($chapter_id = NULL)
  {
    //print_r($this->input->post());exit;
    $this->check_chapter_ownership($chapter_id);    
    $this->db->trans_start(); 
    $sentence_data = array(
      'source_sentence' => strip_tags($this->input->post('source_sentence')),
      'translated_sentence' => strip_tags($this->input->post('translated_sentence')),
      'difficulty' => 1,
      'chapter_id' => $chapter_id,
    );
    $this->db->insert('sentences', $sentence_data);
    // now handle the alt_translations
    $sentence_id = $this->db->insert_id(); // MySQL LAST_INSERT_ID() equivalent (get the last insert id) Note: it is safe as it is connection dependent
    foreach ($this->input->post('alt_translated_sentence') as $value) {
      if(!empty($value)){
        $this->db->insert('alt_translations', array(
          'translated_sentence' => strip_tags($value),
          'sentence_id' => $sentence_id,
        ));
      }
    }
    $this->db->trans_complete();
    //exit();
    return;
  }

  // use the batch uploader to upload tab separated entries/sentences
	public function create_batch($chapter_id)
	{
    $this->check_chapter_ownership($chapter_id);
		$chapter_id = (int)$chapter_id;
		$errors = []; 

    $post_data = strip_tags($this->input->post('textarea_batch')); // input sanitation step
		$post_data = preg_replace("/\t+/", "\t", $post_data); // remove ajoining tabs (ie. \t\t\t)
    
    $entry_array = explode("\n", $post_data); // each line to an indexed array with string value 
    //var_dump($entry_array);exit;
		
    // make sure each line/entry contains minimum amount of required tabs
    if(substr_count($post_data, "\t") === 0) {
      $errors[] = "Error: No tabs detected. Have they been converted to spaces?";
    }

    //$lines = [];
    
    // 
		foreach ($entry_array as $entry_key => $entry)
		{
			$entry_line = explode("\t", $entry); // use tabs to break each indexed entry/line into an indexed array of entries 
      //var_dump($entry_line);
			for ($i=0; $i < count($entry_line); $i++)
			{
				// check whether there is at least a source and translation string
				if (strlen(str_replace(array("\n", "\r\n", "\r"), '', $entry)) === 0) {
					// note, \n is counted as a character
					$errors[] = "Warning: Line ".($entry_key + 1)." appears to be blank and has been ignored.";
					break;
        }
        // if entry doesn't seem to contain a translation
				if(count($entry_line) < 2) {
					$errors[] = "Warning: Line ".($entry_key + 1)." doesn't appear to be a complete entry and has been ignored.";
					break;
				}

				// assign each indexed entry array to multidimentional associative arrays ($sentences) do a var dump to see this more clearly
				if($i === 0){
					// assign to source
					$sentences[$entry_key]['source'] = $entry_line[$i];
				}
				elseif ($i === 1) {
					// assign to translation
					$sentences[$entry_key]['translation'] = $entry_line[$i];
				}
				else {
					// assign to the alt array
					$sentences[$entry_key]['alt'][] = $entry_line[$i];
				}

			}

    }
    
		if(!isset($sentences)) { $errors[] = '<p>Error: No complete entries detected.</p>'; }

		if(count($errors) > 0) {
			foreach ($errors as $error) { echo '<p>'.$error.'</p>'; } // set as session flashdata 
    }

    // 
    
    //var_dump($sentences); 
    //exit;

    $this->db->trans_start();     
    foreach ($sentences as $key => $sentence) {
      // put source and translation into sentence table  
      $sentence_data = array(
        'source_sentence' => $sentence['source'],
        'translated_sentence' => $sentence['translation'],
        'difficulty' => 1,
        'chapter_id' => $chapter_id,
      );
      $this->db->insert('sentences', $sentence_data);
      // now handle the alt_translations (they go into a joining table)
      $sentence_id = $this->db->insert_id(); // MySQL LAST_INSERT_ID() equivalent (get the last insert id) Note: it is safe as it is connection dependent
      if (!empty($sentence['alt'])) {
        foreach ($sentence['alt'] as $alt_translation) {
          if(!empty(trim($alt_translation))){
            $this->db->insert('alt_translations', array(
              'translated_sentence' => $alt_translation,
              'sentence_id' => $sentence_id,
            ));
          }
        }
      }
    }
    $this->db->trans_complete();
    
    return;
	}

  public function update($chapter_id, $sentence_id)
  {
    //print_r($this->input->post()); exit;
    $this->check_chapter_ownership($chapter_id);

    $sentence_data = array(
      'source_sentence' => $this->input->post('source_sentence'),
      'translated_sentence' => $this->input->post('translated_sentence'),
      'difficulty' => 1,
    );
    $this->db->where('id', $sentence_id);
    $this->db->update('sentences', $sentence_data);

    /* now handle the alt_translations. this is different to the create() method
    now, as there is no need to get the last generated insert_id(), and the 
    alt_translation values come with their own ids. This time, empty rows signify deletion. 
    If there is a alt_translation entry with no key, issue an insert. */
    $alt_translated_sentence = $this->input->post('alt_translated_sentence');
    //print_r($alt_translated_sentence); exit;
    foreach ($alt_translated_sentence as $key => $sentence) {
      $keyID = explode('_', $key); // find the keys that have id_ prefix in the string.
      if($keyID[0] === 'id') {
        // this means they were existing entries pulled from the db
        if(mb_strlen($sentence, 'utf8') > 0){
          // UPDATE if the field is not empty
          $this->db->where('id', $keyID[1]);
          $this->db->update('alt_translations', array('translated_sentence' => $sentence));  
        } 
        else {
          // the field was empty. (note, mb_strlen + encoding checks the string length correctly)
          // DELETE the entry from the db
          $this->db->delete('alt_translations', array('id' => $keyID[1]));
        }
      }
      else {
        // no id_ prefix was found. these are brand new entries
        // INSERT (note, we still need to check the length as this isn't covered by the form validation)
        if(mb_strlen($sentence, 'utf8') > 0){
          $this->db->insert('alt_translations', array(
            'translated_sentence' => $sentence,
            'sentence_id' => $sentence_id,
          ));
        }
      }
    }
    return;
  }

  public function delete($chapter_id = NULL, $sentence_id = NULL)
  {
    $this->check_chapter_ownership($chapter_id);    
    return $this->db->delete('sentences', array('id' => $sentence_id));
  }

  // get all the sentences from the chapter set 
  private function get_chapter_words($chapter_id){
    // get all the sentences and alt_sentences for the given chapter
    $this->db->select("translated_sentence")
    ->from("sentences")
    ->where("sentences.chapter_id", $chapter_id);
    $query1 = $this->db->get_compiled_select();

    $this->db->select("alt_translations.translated_sentence")
    ->from("sentences")
    ->join('alt_translations', 'sentences.id = alt_translations.sentence_id', 'left')
    ->where("sentences.chapter_id", $chapter_id);
    $query2 = $this->db->get_compiled_select();

    $query = $this->db->query($query1." UNION ALL ".$query2);    
    //print_r($query->result());
    $unique_words = [];

    // break up sentences and push unique words to an array
    foreach ($query->result() as $sentence){
      $words = explode(" ", $sentence->translated_sentence);
      foreach ($words as $key => $word) {
        $word = strtolower($word); // can't use strtolower inside in_array for some reason
        if (!in_array($word, $unique_words)) {
          $unique_words[] = $word;
        }
      }
    }
    //print_r($unique_words);exit;
    shuffle($unique_words);
    return $unique_words;
  }
  
  // get sentences for the practice test
  public function get_practice_sentences($chapter_id)
  {
    $query = $this->db->query("SELECT * FROM sentences WHERE chapter_id = $chapter_id");

    $unique_words = array_slice($this->get_chapter_words($chapter_id), 0, 2); // get first 2 array elements 
    $server_data = [];
    // prepare the practice sentences 
    // TODO: Get the alternate sentences 
    foreach ($query->result() as $row)
    {
      $staged_sentence = explode(" ", $row->translated_sentence);
      $extra_stage_data = $unique_words;
      $staged_sentence = array_merge($staged_sentence, $extra_stage_data);
      shuffle($staged_sentence);

      array_push($server_data, [
        $row->source_sentence,
        $row->translated_sentence,
        $staged_sentence
      ]);
    }
    
    $server_data = json_encode( xss_clean($server_data) );
    //print_r($server_data); exit;
    //$query = $this->db->get_where('news', array('slug' => $slug));
    //return $query->row_array();
    return $server_data;
  }


}
