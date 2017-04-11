<?php
// class News_model extends CI_Model {

//     public function __construct()
//     {
//         $this->load->database();
//     }

//     public function get_news($newsID = FALSE)
//     {
//         if ($newsID === FALSE)
//         {
//             $query = $this->db->get('news');
//             return $query->result_array();
//         }

//         $query = $this->db->get_where('news', array('newsID' => $newsID));
//         return $query->row_array();
//     }

//     public function set_news()
//     {
//         $this->load->helper('url');

//         $newsID = url_title($this->input->post('title'), 'dash', TRUE);

//         $data = array(
//             'title' => $this->input->post('title'),
//             'newsID' => $newsID,
//             'content' => $this->input->post('content')
//         );

//         return $this->db->insert('news', $data);
//     }
// }
