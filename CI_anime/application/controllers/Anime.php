<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Anime extends CI_Controller 
{
    function __construct()
    {
        parent::__construct();
        $this->load->model('initor');
        
    }
	public function index()
	{
        $this->load->view('anime_view');
        $this->get_data('DiLi_anime');
    }
    function get_data($table_name)
    {
        $query = $this->db->get($table_name);
        $data=[];
        foreach ($query->result_array() as $row)
        {
            $data[] = array(
                'id' => $row['anime_id'],
                'img_url' => $row['anime_img'],
                'url' => $row['anime_url'],
                'name' => $row['anime_name'],
                'info' => $row['anime_info']
            );
        }
        $this->initor->response_Json($data);
    }
}


