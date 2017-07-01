<?php if (!defined('BASEPATH')) exit('No direct script access allowed');


class MY_Controller extends CI_Controller
{


    public function __construct()
    {

        parent::__construct();


        //Load Models.............

        //$this->odb2 = $this->load->database('db2', TRUE);
        $this->load->model('menus');

        $this->load->model('general');

        $this->load->model('user');
        $this->load->model('main_model');

        $this->load->helper("url");
        $this->load->helper("admin");
        $this->load->helper("alert");

        $this->load->library("pagination");


    }

    //Header for Applications...................................

    public function header($title = '')
    {

        $data['parent_nav'] = $this->menus->fetch_parent_navi();

        $data['My_Controller'] = $this;
//echo "<pre>";
        $data['title'] = $title;
        //print_r($data);
//exit;
        $this->load->view('_template/header', $data);


    }

    public function main_content()
    {

        $data['result'] = $this->main_model->get_daily_sales();
        $data["daily_p"] = $this->main_model->get_daily_purchase();
        $data["daily_st"] = $this->main_model->get_daily_stock();
        $data['due_amounts'] = $this->main_model->due_amounts();
        $data['tot_pur'] = $this->db->query("SELECT COUNT(purchase_no) AS total,SUM(`grand_total`) AS purchases,SUM(`purchase_amount_total`) AS purchase,
 SUM(purchase_discount) AS p_discount 

FROM `purchase_company`")->row();
        $data['tot_sales'] = $this->db->query("SELECT COUNT(sales_no) AS total,SUM(`grand_total`) AS sales,SUM(`sales_amount_total`) AS purchase,
 SUM(sales_discount) AS p_discount 

FROM `sales`")->row();

        $data['recentPurchases'] = $this->db->query("SELECT 
 pc.`pur_no`, c.`company_name`,v.`vendor_name`, pc.`grand_total`,pc.`purchase_date`
FROM
  `purchase_company` AS pc, company AS c, vendor AS v
  WHERE pc.`vendor_id` = v.`vendor_id`
  AND pc.`company_id` = c.`company_id`
  ORDER BY pc.`purchase_no` DESC
    LIMIT 10 ")->result();


        $data['topsales'] = $this->db->query("SELECT 
 SUM(s.sales_qty) AS qty, c.`item_name`,c.item_id
FROM
  `sales_detail` AS s, item AS c
  WHERE s.item_id = c.item_id

  ORDER BY s.`sales_id` DESC
    LIMIT 5")->result();




        $data['sales'] = $this->db->query("SELECT  COUNT(sales_no) AS total, SUM(`sales_amount_total`) AS sales ,SUM(sales_discount) AS discount,
(SELECT SUM(`purchase_amount_total`) FROM `purchase_company`) AS purchases
FROM `sales`")->row();
        $this->load->view('_template/main', $data);
    }


    public function footer()
    {

        $this->load->view('_template/footer');

    }

    public function fetchsidebar_childMenuById($child_id)
    {


        if ($this->session->userdata('group_id') == 1) {

            $query = $this->db->query("SELECT * FROM usr_menu WHERE PARENT_ID =$child_id AND SHOW_IN_MENU = 1 ORDER BY SORT_ORDER ASC");

        }


        if ($this->session->userdata('group_id') != 1) {

            $group = $this->session->userdata('group_id');

            $query = $this->db->query("SELECT * FROM usr_menu AS UM , usr_permission UP

                                        WHERE

                                        UM.MENU_ID = UP.MENU_ID

                                        AND 

                                        UP.PER_SELECT =1 

                                        AND

                                        UP.GROUP_ID = $group

                                        AND

                                        UM.PARENT_ID =$child_id AND SHOW_IN_MENU = 1 ORDER BY SORT_ORDER ASC");

        }


        return $query->result();


    }

    //SET SAVE, DELETE, UPDATE, PERMISSIONS FOR PAGES.........................

    public function Getsave_up_delPermissions()
    {


        $menu_id = $this->session->userdata("menu_id");

        if (!empty($menu_id) && $this->session->userdata("group_id") != 1) {


            $menu_id = $this->session->userdata("menu_id");
            $group_id = $this->session->userdata("group_id");

            $permissionResult = $this->general->fetch_CoustomQuery("SELECT * FROM `usr_permission`

												  WHERE    GROUP_ID=$group_id   AND 

												  MENU_ID=$menu_id");


            foreach ($permissionResult as $permissionResults) {


                //SET SAVE BUTTON PERMISSION...............................................................

                if ($permissionResults->PER_INSERT == 1) {


                    $this->savePermission = "<input type='submit' value='save' class='btn btn-success' >";


                } elseif ($permissionResults->PER_INSERT == 0) {


                    $this->savePermission = "<input type='button' value='save' class='btn btn-success' >";


                }


                //SET UPDATE BUTTON PERMISSION...............................................................

                if ($permissionResults->PER_UPDATE == 1) {


                    $this->editPermission = "";


                } elseif ($permissionResults->PER_UPDATE == 0) {


                    $this->editPermission = "style='display:none;'";


                }


                //SET DELETE BUTTON PERMISSION...............................................................

                if ($permissionResults->PER_DELETE == 1) {


                    $this->deletePermission = "";


                } elseif ($permissionResults->PER_DELETE == 0) {


                    $this->deletePermission = "style='display:none;'";


                }


            }


        } elseif ($this->session->userdata("group_id") == 1) {


            $this->savePermission = "<input type='submit' value='save' class='btn btn-success' >";

            $this->editPermission = "";

            $this->deletePermission = "";


        }//End Condition......


    }


}


?>