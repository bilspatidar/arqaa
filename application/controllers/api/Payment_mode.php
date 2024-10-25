<?php
require APPPATH . '/libraries/REST_Controller.php';
use Restserver\Libraries\REST_Controller;

class Payment_mode extends REST_Controller {

    public function __construct() {
        $this->cors_header();
        parent::__construct();
        $this->load->model('payment_mode_model');
        $this->load->helper('security');
    }

    public function payment_mode_list_post() {
        $input_data = file_get_contents('php://input');
        $request_data = json_decode($input_data, true);

        $id = $this->input->get('id') ? $this->input->get('id') : 0;

        $page = isset($request_data['page']) ? $request_data['page'] : 1; // Default to page 1 if not provided
        $limit = isset($request_data['limit']) ? $request_data['limit'] : 10; // Default limit to 5 if not provided
        $filterData = isset($request_data['filterData']) ? $request_data['filterData'] : [];


        $getTokenData = $this->is_authorized('superadmin');
        $offset = ($page - 1) * $limit;
        
        $totalRecords         =  $this->payment_mode_model->get('yes',$id,$limit,$offset,$filterData);
        $data         =  $this->payment_mode_model->get('no',$id,$limit,$offset,$filterData);
      
        $totalPages = ceil($totalRecords / $limit);

        $response = [
            'status' => true,
            'data' => $data,
            'pagination' => [
                'page' => $page,
                'totalPages' => $totalPages,
                'totalRecords' => $totalRecords
            ],
            'message' => 'Payment fetched successfully.'
        ];
       $this->response($response, REST_Controller::HTTP_OK); 
    }
   
    public function payment_mode_details_get(){
        $id = $this->input->get('id') ? $this->input->get('id') : 0;
        $getTokenData = $this->is_authorized('superadmin');
        $data =  $this->payment_mode_model->show($id);
        $response = [
            'status' => true,
            'data' => $data,
            'message' => 'Payment_mode details fetched successfully.'
        ];
        $this->response($response, REST_Controller::HTTP_OK); 
    }

    public function payment_mode_post($params='') {
        if ($params == 'add') {
            $getTokenData = $this->is_authorized('superadmin');
            $usersData = json_decode(json_encode($getTokenData), true);
            $session_id = $usersData['data']['id'];

            $_POST = json_decode($this->input->raw_input_stream, true);

            // set validation rules
             $this->form_validation->set_rules('name', 'Name', 'trim|required|xss_clean|alpha_numeric_spaces');
           
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
                $data = array(
                    'name' => $this->input->post('name', TRUE),
                    'description' => $this->input->post('description', TRUE),
                    'status' => 'Active',
                    'added' => date('Y-m-d H:i:s'),
                    'addedBy' => $session_id
                );

                if ($res = $this->payment_mode_model->create($data)) {
                    $final = array();
                    $final['status'] = true;
                    $final['data'] = $this->payment_mode_model->get($res);
                    $final['message'] = 'Payment mode created successfully.';
                    $this->response($final, REST_Controller::HTTP_OK);
                } else {
                    $this->response([
                        'status' => FALSE,
                        'message' =>'Error in submit form',
                        'errors' =>[$this->db->error()]], REST_Controller::HTTP_BAD_REQUEST,'','error');
                }
            }
        }

        if ($params == 'update') {
            $getTokenData = $this->is_authorized('superadmin');
            $usersData = json_decode(json_encode($getTokenData), true);
            $session_id = $usersData['data']['users_id'];
    
            $_POST = json_decode($this->input->raw_input_stream, true);
    
            // set validation rules
          
            $this->form_validation->set_rules('name', 'Name', 'trim|required|xss_clean|alpha_numeric_spaces');
           
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
                $id = $this->input->post('id', TRUE);
    
                $data = array(
                    'name' => $this->input->post('name', TRUE),
                    'description' => $this->input->post('description', TRUE),
                    'status' =>  $this->input->post('status', TRUE),
                    'updated' => date('Y-m-d H:i:s'),
                    'updatedBy' => $session_id
                );
    
                if ($this->payment_mode_model->update($data, $id)) {
                    $final = array();
                    $final['status'] = true;
                    $final['data'] = $this->payment_mode_model->get($id);
                    $final['message'] = 'Payment mode updated successfully.';
                    $this->response($final, REST_Controller::HTTP_OK);
                } else {
                    $this->response([
                        'status' => FALSE,
                        'message' =>'Error in update',
                        'errors' =>[$this->db->error()]], REST_Controller::HTTP_BAD_REQUEST,'','error');
                }
            }
        }
    }

    public function payment_mode_delete($id) {
        $this->is_authorized('superadmin');
        $response = $this->payment_mode_model->delete($id);

        if ($response) {
            $this->response(['status' => true, 'message' => 'Payment mode deleted successfully.'], REST_Controller::HTTP_OK);
        } else {
            $this->response(['status' => false, 'message' => 'Not deleted'], REST_Controller::HTTP_BAD_REQUEST);
        }
    }

}
