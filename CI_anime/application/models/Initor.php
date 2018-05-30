<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Initor extends CI_Model
{
    function __construct()
    {
        parent::__construct();
        $this->load->database();
    }
    function response_Json($data)
    {
        if (is_array($data)||is_object($data))
            echo json_encode($data);
        else
            echo $data;
    }
}