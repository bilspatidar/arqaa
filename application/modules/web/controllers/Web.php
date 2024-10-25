<?php
defined('BASEPATH') OR exit('No direct script access allowed ');
class Web extends CI_Controller {

    function __construct() {
        parent::__construct(); 
		//$this->load->model('Web_model');
    }
    public function index(){
      $this->load->view('header');
      $this->load->view('index');
      $this->load->view('footer');
    }
    public function about(){
      $this->load->view('header');
      $this->load->view('about');
      $this->load->view('footer');
    }
    public function services(){
      $this->load->view('header');
      $this->load->view('services');
      $this->load->view('footer');
    }
    public function projects(){
      $this->load->view('header');
      $this->load->view('projects');
      $this->load->view('footer');
    }
    public function project_details($project_id=''){
      $data['project_id'] = $project_id;
      $this->load->view('header');
      $this->load->view('project_details',$data);
      $this->load->view('footer');
    }
    public function blog($blog_cat_id=''){
      $data['blog_cat_id'] = $blog_cat_id;
      $this->load->view('header');
      $this->load->view('blog',$data);
      $this->load->view('footer');
    }
    public function blog_details($blog_id=''){
      $data['blog_id'] = $blog_id;
      $this->load->view('header');
      $this->load->view('blog_details',$data);
      $this->load->view('footer');
    }
    public function service_details($service_id=''){
      $data['service_id'] = $service_id;
      $this->load->view('header');
      $this->load->view('service_details',$data);
      $this->load->view('footer');
    }
    public function contact(){
      $this->load->view('header');
      $this->load->view('contact');
      $this->load->view('footer');
    }
    public function category(){
        $user_detais = $this->session->userdata('user_detais');
        $page_data['token'] =  $user_detais['access_token'];
        $this->load->view('category',$page_data);
    }
    public function add_contact() {
      log_message('debug', 'add_contact method called'); // Log method call
  
      $this->form_validation->set_error_delimiters('', '');
      $this->form_validation->set_rules('name', 'Name', 'required');
      $this->form_validation->set_rules('phone', 'Mobile', 'required');
  
      if ($this->form_validation->run() == FALSE) {
          $response['status'] = 0;
          $response['msg']  = validation_errors();
          log_message('error', 'Form validation failed: ' . validation_errors());
      } else {
          $data['name'] = $this->input->post('name');
          $data['phone'] = $this->input->post('phone');
          $data['address'] = $this->input->post('address');
          $data['message'] = $this->input->post('message');
          log_message('debug', 'Form data: ' . json_encode($data)); // Log form data
  
          $result = $this->db->insert('contact', $data);
          
          if ($result) {
              $response['status'] = 1;
              $response['msg']  = 'Data submitted successfully';
              log_message('debug', 'Data inserted successfully');
          } else {
              $response['status'] = 0;
              $response['msg']  = 'Error try again';
              log_message('error', 'Database insert failed');
          }
      }
  
      echo json_encode($response);
      log_message('debug', 'Response: ' . json_encode($response)); // Log response
  }
    public function edit_form($page='',$table='',$key='',$value=''){
		
		$page_data['row'] = $this->db->get_where($table,array($key=>$value))->result();
		$page_data['token'] = $_POST['token'];
		$this->load->view($page,$page_data);
	}

} 
?>




