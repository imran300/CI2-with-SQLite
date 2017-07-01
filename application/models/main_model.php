<?php

class Main_model extends CI_Model
{

    protected $cms_db;

    public function __construct()
    {
        parent::__construct();
        $this->cms_db = $this->load->database('forum', TRUE);
    }

    function get_posts(){

        $this->db->select('name');
        $query = $this->cms_db->get('orang');
        return $query->result();

    }
}


?>