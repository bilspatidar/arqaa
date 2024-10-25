<?php
defined('BASEPATH') OR exit('No direct script access allowed ');
class Loan_management extends CI_Controller {

    function __construct() {
        parent::__construct(); 
    }


    public function emi(){
	  //ini_set('display_errors',1);
      $header_data['page_title'] = "Emi";
      $this->load->view('includes/header',$header_data);
      $this->load->view('loan_management/emi');
      $this->load->view('includes/footer');
    }
 
} 
?>




