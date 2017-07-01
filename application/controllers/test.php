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
        echo "<pre>";
        //var_dump($data['records']);
        $output = '';
        echo "<table border='1'><thead><tr><td>ID</td><td>NAME</td></tr></thead><tbody>";
        foreach ($data['records'] as $item) {
            $output .= "
            <tr>
<td>$item->id</td>
<td>$item->name</td>
</tr>";
        }
            $output .= "</tbody></table>";

        echo $output;
    }
}