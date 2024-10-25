<?php
require APPPATH . '/libraries/REST_Controller.php';
use Restserver\Libraries\REST_Controller;

class Customer_wallet extends REST_Controller {

    public function __construct() {
        $this->cors_header();
        parent::__construct();
        $this->load->model('customer_wallet_model');
        $this->load->helper('security');
    }

    public function wallet_list_post() {
        $input_data = file_get_contents('php://input');
        $request_data = json_decode($input_data, true);
    
        $id = $this->input->get('id') ? $this->input->get('id') : 0;
    
        $page = isset($request_data['page']) ? $request_data['page'] : 1; // Default to page 1 if not provided
        $limit = isset($request_data['limit']) ? $request_data['limit'] : 10; // Default limit to 10 if not provided
        $filterData = isset($request_data['filterData']) ? $request_data['filterData'] : [];
    
        $getTokenData = $this->is_authorized('superadmin');
        $offset = ($page - 1) * $limit;
    
        $totalRecords =  $this->customer_wallet_model->get('yes', $id, $limit, $offset, $filterData);
        $data =  $this->customer_wallet_model->get('no', $id, $limit, $offset, $filterData);
    
        $totalPages = ceil($totalRecords / $limit);
    
        $response = [
            'status' => true,
            'data' => $data,
            'pagination' => [
                'page' => $page,
                'totalPages' => $totalPages,
                'totalRecords' => $totalRecords
            ],
            'message' => 'Wallet fetched successfully.'
        ];
        $this->response($response, REST_Controller::HTTP_OK); 
    }
    
    public function wallet_details_get(){
        $id = $this->input->get('id') ? $this->input->get('id') : 0;
        $getTokenData = $this->is_authorized('superadmin');
        $data =  $this->customer_wallet_model->show($id);
        $response = [
            'status' => true,
            'data' => $data,
            'message' => 'Wallet fetched successfully.'
        ];
        $this->response($response, REST_Controller::HTTP_OK); 
    }

    public function wallet_post($params='') {
        if($params == 'add') {
            $getTokenData = $this->is_authorized('superadmin');
            $usersData = json_decode(json_encode($getTokenData), true);
            $session_id = $usersData['data']['users_id'];

            $_POST = json_decode($this->input->raw_input_stream, true);

            // set validation rules
            $this->form_validation->set_rules('title', 'Title', 'trim|required|xss_clean');
            $this->form_validation->set_rules('amount', 'Amount', 'trim|required|xss_clean|numeric');
            $this->form_validation->set_rules('description', 'Description', 'trim|required|xss_clean');
  
            if ($this->form_validation->run() === false) {
                $array_error = array_map(function ($val) {
                    return str_replace(array("\r", "\n"), '', strip_tags($val));
                }, array_filter(explode(".", trim(strip_tags(validation_errors())))));

                $this->response([
                    'status' => FALSE,
                    'message' =>'Error in submit form',
                    'errors' =>$array_error
                ], REST_Controller::HTTP_BAD_REQUEST,'','error');
            } else {
                // set variables from the form
                $data['title'] = $this->input->post('title', TRUE);
                $data['amount'] = $this->input->post('amount', TRUE);
                $data['description'] = $this->input->post('description', TRUE);
                $data['added'] = date('Y-m-d H:i:s');
                $data['added_by'] = $session_id;

                if ($res = $this->customer_wallet_model->create($data)) {
                    // Wallet creation successful
                    $final = array();
                    $final['status'] = true;
                    $final['data'] = $this->customer_wallet_model->get($res);
                    $final['message'] = 'Wallet created successfully.';
                    $this->response($final, REST_Controller::HTTP_OK); 
                } else {
                    // Wallet creation failed
                    $this->response([
                        'status' => FALSE,
                        'message' =>'Error in submit form',
                        'errors' =>[$this->db->error()]
                    ], REST_Controller::HTTP_BAD_REQUEST,'','error');
                }
            }
        }

        if ($params == 'update') {
            $getTokenData = $this->is_authorized('superadmin');
            $usersData = json_decode(json_encode($getTokenData), true);
            $session_id = $usersData['data']['users_id'];
        
            $_POST = json_decode($this->input->raw_input_stream, true);
        
            // Set validation rules
            $this->form_validation->set_rules('title', 'Title', 'trim|required|xss_clean');
            $this->form_validation->set_rules('amount', 'Amount', 'trim|required|xss_clean|numeric');
            $this->form_validation->set_rules('description', 'Description', 'trim|required|xss_clean');
        
            if ($this->form_validation->run() === false) {
                $array_error = array_map(function ($val) {
                    return str_replace(array("\r", "\n"), '', strip_tags($val));
                }, array_filter(explode(".", trim(strip_tags(validation_errors())))));
        
                $this->response([
                    'status' => FALSE,
                    'message' => 'Error in submit form',
                    'errors' => $array_error
                ], REST_Controller::HTTP_BAD_REQUEST, '', 'error');
            } else {
                // Set variables from the form
                $data['title'] = $this->input->post('title', TRUE);
                $data['amount'] = $this->input->post('amount', TRUE);
                $data['description'] = $this->input->post('description', TRUE);
        
                // Update the 'updatedBy' and 'updated' fields
                   $data['update_by'] = $session_id;
                   $data['updated'] = date('Y-m-d H:i:s');
        
                // Get the ID from the request
                $id = $this->input->post('id');
        
                // Perform the update operation
                $res = $this->customer_wallet_model->update($data, $id);
        
                if ($res) {
                    // Wallet update successful
                    $final = array();
                    $final['status'] = true;
                    $final['data'] = $this->customer_wallet_model->get($id);
                    $final['message'] = 'Wallet updated successfully.';
                    $this->response($final, REST_Controller::HTTP_OK);
                } else {
                    // Wallet update failed
                    $this->response([
                        'status' => FALSE,
                        'message' => 'There was a problem updating Wallet. Please try again',
                        'errors' => [$this->db->error()]
                    ], REST_Controller::HTTP_BAD_REQUEST, '', 'error');
                }
            }
        }
        
    }

    public function wallet_delete($id) {
        $this->is_authorized('superadmin');
        $response = $this->customer_wallet_model->delete($id);

        if ($response) {
            $this->response(['status' => true, 'message' => 'Wallet deleted successfully.'], REST_Controller::HTTP_OK);
        } else {
            $this->response(['status' => false, 'message' => 'Not deleted'], REST_Controller::HTTP_BAD_REQUEST);
        }
    }
}
