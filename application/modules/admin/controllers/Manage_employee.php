<?php
defined('BASEPATH') OR exit('No direct script access allowed ');
class Manage_employee extends CI_Controller {

    function __construct() {
        parent::__construct(); 
    }


    public function branch(){
      $header_data['page_title'] = "Site";
      $this->load->view('includes/header',$header_data);
      $this->load->view('manage_employee/branch');
      $this->load->view('includes/footer');
    }
 public function branch_transfer(){
	  //ini_set('display_errors',1);
      $header_data['page_title'] = "Branch Transfers";
      $this->load->view('includes/header',$header_data);
      $this->load->view('manage_employee/branch_transfer');
      $this->load->view('includes/footer');
    }

    public function user_branch_link(){
      //ini_set('display_errors',1);
        $header_data['page_title'] = "User Branch Link";
        $this->load->view('includes/header',$header_data);
        $this->load->view('manage_employee/user_branch_link');
        $this->load->view('includes/footer');
      }
} 
?>




