<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class welcome extends CI_Controller
{

    /**
     * Index Page for this controller.
     *
     * Maps to the following URL
     *        http://example.com/index.php/welcome
     *    - or -
     *        http://example.com/index.php/welcome/index
     *    - or -
     * Since this controller is set as the default controller in
     * config/routes.php, it's displayed at http://example.com/
     *
     * So any other public methods not prefixed with an underscore will
     * map to /index.php/welcome/<method_name>
     * @see http://codeigniter.com/user_guide/general/urls.html
     */
    public function index()
    {
        //$data['main_content']='dashboard';
        //	$this->load->view('layouts/main',$data);
        error_reporting(E_ALL);
        echo "Here is the link to your data fetched form SQLite DB <a href='".base_url('test/testing')."'>Go to SQLite Data</a>";
        //$this->load->view('welcome_message');
    }
    
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */