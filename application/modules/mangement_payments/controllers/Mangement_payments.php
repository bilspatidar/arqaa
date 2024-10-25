<?php
defined('BASEPATH') OR exit('No direct script access allowed ');
class Mangement_payments extends CI_Controller {

    function __construct() {
        parent::__construct(); 
    }

    public function account_head(){
    
      is_login(array('superadmin'));
      $header_data['page_title'] = "Account Head";
      $this->load->view('includes/header',$header_data);
      $this->load->view('mangement_payments/account_head');
      $this->load->view('includes/footer');
    }

    public function payment_voucher(){
    
      is_login(array('superadmin'));
      $header_data['page_title'] = "Payment Voucher";
      $this->load->view('includes/header',$header_data);
      $this->load->view('mangement_payments/payment_voucher');
      $this->load->view('includes/footer');
    }

    public function payment_mode(){
    
      is_login(array('superadmin'));
      $header_data['page_title'] = "Payment Mode";
      $this->load->view('includes/header',$header_data);
      $this->load->view('mangement_payments/payment_mode');
      $this->load->view('includes/footer');
    }




} 
?>




