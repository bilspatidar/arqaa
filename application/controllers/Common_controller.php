<?php


//deploy ok oksss okkk mmm
class Common_controller extends CI_Controller {
    
	  /**
     * CONSTRUCTOR | LOAD MODEL
     *
     * @return Response
    */
    public function __construct() {
	header('Access-Control-Allow-Origin: *');
    header("Access-Control-Allow-Headers: X-API-KEY, Origin, X-Requested-With, Content-Type, Accept, Access-Control-Request-Method");
    header("Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE");
    $method = $_SERVER['REQUEST_METHOD'];
    if($method == "OPTIONS") {
        die();
    }
    parent::__construct();
     	   header('Access-Control-Allow-Origin: *');
	}
	
	function ccc(){
	    echo $this->Common->get_user_currency(70006);
	}
	
    public function edit_form(){
        is_login();
        $this->load->library('curls/EditApiCurl');
        $tableId = $_POST['tableId'];
        $show_endpoint = $_POST['show_endpoint'];
        $edit_page_name = $_POST['edit_page_name'];
        $response =  $this->editapicurl->getTableDetails($tableId, $show_endpoint);
    
        if($response['status']=='ok' && $response['http_status_code']==200){
        
         $responseData =  json_decode($response['data'], true);
         $page_data['data'] = $responseData['data'][0];
		$this->load->view($edit_page_name,$page_data);
        $this->load->view('includes/editJs');
        }
        else{
            echo $response['http_status_code'].' '.$response['message'];
        }
	}
	public function get_states_by_country() {
        $country_id = $this->input->post('country_id'); // Get country ID from POST request
        $states = $this->Internal_model->get_state($country_id); // Fetch states based on country ID
    
        // Generate the HTML for the state dropdown
        $output = '<option value="">' . $this->lang->line('select_option') . '</option>';
        foreach ($states as $state) {
            $output .= '<option value="' . $state->id . '">' . $state->name . '</option>';
        }
    
        echo $output; // Send the HTML back to the frontend
    }
    
    
	
}
