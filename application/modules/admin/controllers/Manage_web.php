<?php
defined('BASEPATH') OR exit('No direct script access allowed ');
class Manage_web extends CI_Controller {

    function __construct() {
        parent::__construct(); 
    }

    public function blog_category(){
    
      is_login(array('superadmin'));
      $header_data['page_title'] = "Blog Category";
      $this->load->view('includes/header',$header_data);
      $this->load->view('manage_web/blog_category');
      $this->load->view('includes/footer');
    }

    public function blogs(){
    
      is_login(array('superadmin'));
      $header_data['page_title'] = "Blogs";
      $this->load->view('includes/header',$header_data);
      $this->load->view('manage_web/blogs');
      $this->load->view('includes/footer');
    }

    public function contact(){
      is_login(array('superadmin'));
      $header_data['page_title'] = "Contact";
      $this->load->view('includes/header',$header_data);
      $this->load->view('manage_web/contact');
      $this->load->view('includes/footer');
    }

    public function about(){
      is_login(array('superadmin'));
      $header_data['page_title'] = "About";
      $this->load->view('includes/header',$header_data);
      $this->load->view('manage_web/about');
      $this->load->view('includes/footer');
    }

    public function services(){
    
      is_login(array('superadmin'));
      $header_data['page_title'] = "Services";
      $this->load->view('includes/header',$header_data);
      $this->load->view('manage_web/services');
      $this->load->view('includes/footer');
    }
    
    
    public function faq(){
    
      is_login(array('superadmin'));
      $header_data['page_title'] = "FAQS";
      $this->load->view('includes/header',$header_data);
      $this->load->view('manage_web/faq');
      $this->load->view('includes/footer');
    }
    
    


   public function edit_form($page='',$table='',$key='',$value=''){
		
		$page_data['row'] = $this->db->get_where($table,array($key=>$value))->result();
		$page_data['token'] = $_POST['token'];
		$this->load->view($page,$page_data);
	}
} 
?>




