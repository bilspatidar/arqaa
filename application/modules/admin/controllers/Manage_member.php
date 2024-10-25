<?php
defined('BASEPATH') OR exit('No direct script access allowed ');
class Manage_member extends CI_Controller {

    function __construct() {
        parent::__construct(); 
    }

    
    public function employee_joining(){
    
      is_login(array('superadmin','admin','supervisor','employee'));
      $header_data['page_title'] = "Employee Joining";
      $this->load->view('includes/header',$header_data);
      $this->load->view('manage_member/employee_joining');
      $this->load->view('includes/footer');
    }
  
    public function user(){
      is_login(array('superadmin','admin','supervisor','employee'));
      $header_data['page_title'] = "User";
      $this->load->view('includes/header',$header_data);
      $this->load->view('manage_member/user');
      $this->load->view('includes/footer');
    }
    
    public function attendance(){
      is_login(array('superadmin','admin','supervisor','employee'));
      $header_data['page_title'] = "Attendance";
      $this->load->view('includes/header',$header_data);
      $this->load->view('manage_member/attendance');
      $this->load->view('includes/footer');
    }
   
    public function employee($id){
    
      is_login(array('superadmin','admin','supervisor','employee'));
      $data['id'] = $id;
      $header_data['page_title'] = "Employee";
      $this->load->view('includes/header',$header_data);
      $this->load->view('manage_member/employee',$data);
      $this->load->view('includes/footer');
    }
    
    
   public function edit_form($page='',$table='',$key='',$value=''){
		
		$page_data['row'] = $this->db->get_where($table,array($key=>$value))->result();
		$page_data['token'] = $_POST['token'];
		$this->load->view($page,$page_data);
	}
} 
?>




