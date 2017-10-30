<?php
defined('BASEPATH') OR exit('No direct script access allowed');

$config['full_tag_open'] = '<ul class="w3-pagination w3-border w3-light-grey">';
$config['full_tag_close'] = '</ul>';

$config['first_link'] = 'First'; // might require more than 5 pages by default to show up
$config['first_tag_open'] = '<li>';
$config['first_tag_close'] = '</li>';

$config['last_link'] = 'Last';
$config['last_tag_open'] = '<li>';
$config['last_tag_close'] = '</li>';

$config['next_link'] = '&raquo;';
$config['next_tag_open'] = '<li>';
$config['next_tag_close'] = '</li>';

$config['prev_link'] = '&laquo;';
$config['prev_tag_open'] = '<li>';
$config['prev_tag_close'] = '</li>';

$config['cur_tag_open'] = '<li class="w3-green"><b><a class="w3-green">';
$config['cur_tag_close'] = '</a></b></li>';

$config['num_tag_open'] = '<li>';
$config['num_tag_close'] = '</li>';

//$config['page_query_string'] = TRUE;
//$config['reuse_query_string'] = TRUE; // pass the query string to the first pagination if the user navigates to any other
//$config['first_url'] = ''; // An alternative URL to use for the “first page” link.
