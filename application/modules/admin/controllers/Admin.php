<?php
defined('BASEPATH') OR exit('No direct script access allowed ');
class Admin extends CI_Controller {

    function __construct() {
        parent::__construct(); 
       $this->lang->load('information','english');
    }
    
  
    public function swicth_to_country(){
           $country = $this->input->get('country_id');

            if (!empty($country)) {
                // Get existing user details from session
                $user_details = $this->session->userdata('user_details');
            
                // If user details are empty, initialize as an empty array
                if (empty($user_details)) {
                    $user_details = [];
                }
            
                // Add the country_id to user details
                $user_details['country_id'] = $country;
            
                // Update the session with the new user details
                $this->session->set_userdata('user_details', $user_details);
            } else {
                // Get existing user details from session
                $user_details = $this->session->userdata('user_details');
            
                // If user details are not empty, remove 'country_id' from session
                if (!empty($user_details) && isset($user_details['country_id'])) {
                    unset($user_details['country_id']); // Remove country_id
            
                    // Update the session after removing country_id
                    $this->session->set_userdata('user_details', $user_details);
                }
            }
            
            redirect(base_url().'admin/index','refresh');
    }

    public function login(){
     
      $this->load->view('login');
     
    }
	
	 public function logout() {

      if ($this->session->userdata('user_details')) {
        $this->session->unset_userdata('user_details');
        echo"1";
        redirect('admin/login');
        
      } else {
        
        echo"0";
      }
      
    }
    public function forgot_password(){
     
      $this->load->view('forgot_password');
   
    }
    public function otp_send(){
     
      $this->load->view('otp_send');
   
    }

    public function change_password(){
      is_login(array('superadmin','admin','agent','employee','manager'));
      $this->load->view('includes/header');
      $this->load->view('change_password');
      $this->load->view('includes/footer');
    }

    public function profile(){
      is_login(array('superadmin','admin','agent','employee','manager'));
      
     $data['user_id'] = $user_id = $_SESSION['user_details']['id'];

      $this->load->view('includes/header');
      $this->load->view('profile',$data);
      $this->load->view('includes/footer');
    }

    public function index(){
      is_login(array('superadmin','admin','agent','employee','manager'));
      $this->load->view('includes/header');
      $this->load->view('index');
      $this->load->view('includes/footer');
    }

	public function table_name_get(){
		$tables = $this->db->list_tables();
		$sr = 1;
		foreach ($tables as $table){
		   echo $sr ++ .' '.$table.'<br>';
		}
    }

	public function field_name_get(){
    $table = 'users'; 
    $fields = $this->db->list_fields($table);
    $sr = 1;

    echo '<h3>Fields in ' . $table . ' table:</h3>';
    echo '<ul>';
    foreach ($fields as $field){
        echo '<li>' . $sr++ . '. ' . $field . '</li>';
    }
    echo '</ul>';

    // अब fields के data को display करें
    $query = $this->db->get($table); // पूरा table data retrieve करें
    $results = $query->result_array();

    echo '<h3>Data in ' . $table . ' table:</h3>';
    echo '<table border="1" cellpadding="5" cellspacing="0">';
    echo '<tr>';

    // Table header (fields के नाम)
    foreach ($fields as $field){
        echo '<th>' . $field . '</th>';
    }
    echo '</tr>';

    // Table data
    foreach ($results as $row){
        echo '<tr>';
        foreach ($fields as $field){
            echo '<td>' . $row[$field] . '</td>';
        }
        echo '</tr>';
    }
    echo '</table>';
}


    public function edit_form($page='',$table='',$key='',$value=''){
		
		$page_data['row'] = $this->db->get_where($table,array($key=>$value))->result();
		$page_data['token'] = $_POST['token'];
		$this->load->view($page,$page_data);
	}
} 
?>




