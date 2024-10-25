<?php
defined('BASEPATH') OR exit('No direct script access allowed ');
class Salary_management extends CI_Controller {

    function __construct() {
        parent::__construct(); 
    }


    public function salary_head(){
	  //ini_set('display_errors',1);
      $header_data['page_title'] = "Salary Head";
      $this->load->view('includes/header',$header_data);
      $this->load->view('salary_management/salary_head');
      $this->load->view('includes/footer');
    }

    public function salary_level(){
        //ini_set('display_errors',1);
        $header_data['page_title'] = "Salary Level";
        $this->load->view('includes/header',$header_data);
        $this->load->view('salary_management/salary_level');
        $this->load->view('includes/footer');
      }
} 
?>




