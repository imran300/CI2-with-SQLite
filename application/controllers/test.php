<?php

class test extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        // echo 'Test Constructor';
    }

    public function testing()
    {
        //echo "This is the Index";

        $this->load->model('main_model');

        $data['records'] = $this->main_model->get_posts();
        var_dump($data['records']);
        foreach ($data['records'] as $item) {
           // echo $item['name'];
        }
    }
}