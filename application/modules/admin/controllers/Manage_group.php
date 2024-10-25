<?php
defined('BASEPATH') OR exit('No direct script access allowed ');
class Manage_group extends CI_Controller {

    function __construct() {
        parent::__construct(); 
    }


    public function group(){
	  //ini_set('display_errors',1);
      $header_data['page_title'] = "Group";
      $this->load->view('includes/header',$header_data);
      $this->load->view('manage_group/group');
      $this->load->view('includes/footer');
    }

} 
?>




