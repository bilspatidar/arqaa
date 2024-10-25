<?php
defined('BASEPATH') OR exit('No direct script access allowed ');
class Report extends CI_Controller {

    function __construct() {
        parent::__construct(); 
    }


public function expenses_report(){
    
      is_login(array('superadmin','manager'));
      $header_data['page_title'] = "Expenses Report";
      $this->load->view('includes/header',$header_data);
      $this->load->view('report/expenses');
      $this->load->view('includes/footer');
}
public function project_report(){
    
    is_login(array('superadmin','manager','agent'));
    $header_data['page_title'] = "Projects Report";
    $this->load->view('includes/header',$header_data);
    $this->load->view('report/project_report');
    $this->load->view('includes/footer');
}
public function income_report(){
    is_login(array('superadmin','manager'));
    $header_data['page_title'] = "Income Report";
    $this->load->view('includes/header',$header_data);
    $this->load->view('report/income_report');
    $this->load->view('includes/footer');
}
public function attendance_report(){
    is_login(array('superadmin','manager'));
    $header_data['page_title'] = "Attendance Report";
    $this->load->view('includes/header',$header_data);
    $this->load->view('report/attendance_report');
    $this->load->view('includes/footer');
}

    public function edit_form($page='',$table='',$key='',$value=''){
		
		$page_data['row'] = $this->db->get_where($table,array($key=>$value))->result();
		$page_data['token'] = $_POST['token'];
		$this->load->view($page,$page_data);
	}
} 
?>




