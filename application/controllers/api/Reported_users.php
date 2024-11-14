<?php
   require APPPATH . '/libraries/REST_Controller.php';
   use Restserver\Libraries\REST_Controller;

class Reported_users extends REST_Controller {
    
    /**
     * CONSTRUCTOR | LOAD MODEL
     *
     * @return Response
    */
    public function __construct() {
        $this->cors_header();
        parent::__construct();
        $this->load->model('reported_users_model');
        $this->load->helper('security');
    }

    
    public function reported_users_list_post() {
        $input_data = file_get_contents('php://input');
        $request_data = json_decode($input_data, true);
    
        $id = $this->input->get('id') ? $this->input->get('id') : 0;
    
        $page = isset($request_data['page']) ? $request_data['page'] : 1; // Default to page 1 if not provided
        $limit = isset($request_data['limit']) ? $request_data['limit'] : 10; // Default limit to 10 if not provided
        $filterData = isset($request_data['filterData']) ? $request_data['filterData'] : [];
    
        $getTokenData = $this->is_authorized('superadmin');
        $offset = ($page - 1) * $limit;
    
        $totalRecords =  $this->reported_users_model->get('yes', $id, $limit, $offset, $filterData);
        $data =  $this->reported_users_model->get('no', $id, $limit, $offset, $filterData);
    
        $totalPages = ceil($totalRecords / $limit);
    
        $response = [
            'status' => true,
            'data' => $data,
            'pagination' => [
                'page' => $page,
                'totalPages' => $totalPages,
                'totalRecords' => $totalRecords
            ],
            'message' => 'reported users fetched successfully.'
        ];
        $this->response($response, REST_Controller::HTTP_OK); 
    }
    
    public function reported_users_details_get(){
        $id = $this->input->get('id') ? $this->input->get('id') : 0;
        $getTokenData = $this->is_authorized('superadmin');
        $data =  $this->reported_users_model->show($id);
        $response = [
            'status' => true,
            'data' => $data,
            'message' => 'reported users fetched successfully.'
        ];
        $this->response($response, REST_Controller::HTTP_OK); 
    }

    public function reported_users_post($params = '') {
        if ($params == 'add') {
            // Check if the user is authorized
            $getTokenData = $this->is_authorized('superadmin');
            $usersData = json_decode(json_encode($getTokenData), true);
            $session_id = $usersData['data']['id'];
    
            // Parse the input data
            $_POST = json_decode($this->input->raw_input_stream, true);
    
            // Set validation rules
            $this->form_validation->set_rules('user_id', 'User ID', 'trim|required|integer|xss_clean');
            $this->form_validation->set_rules('remark', 'Remark', 'trim|required|xss_clean');
    
            if ($this->form_validation->run() === false) {
                // Validation failed
                $array_error = array_map(function ($val) {
                    return str_replace(array("\r", "\n"), '', strip_tags($val));
                }, array_filter(explode(".", trim(strip_tags(validation_errors())))));
    
                $this->response([
                    'status' => false,
                    'message' => 'Error in form submission',
                    'errors' => $array_error
                ], REST_Controller::HTTP_BAD_REQUEST, '', 'error');
            } else {
                // Prepare the data for insertion
                $data = [
                    'user_id' => $this->input->post('user_id', true),
                    'remark' => $this->input->post('remark', true),
                    'status' => 'Active',
                    'added' => date('Y-m-d H:i:s'),
                    'addedBy' => $session_id
                ];
    
                // Insert the reported user data
                if ($res = $this->reported_users_model->create($data)) {
                    // Success: Return the inserted data
                    $final = [
                        'status' => true,
                        'data' => $this->reported_users_model->get($res),
                        'message' => 'Reported user created successfully.'
                    ];
                    $this->response($final, REST_Controller::HTTP_OK);
                } else {
                    // Failure: Return database error
                    $this->response([
                        'status' => false,
                        'message' => 'Error in form submission',
                        'errors' => [$this->db->error()]
                    ], REST_Controller::HTTP_BAD_REQUEST, '', 'error');
                }
            }
        }
    
    
    
    
        // Check if the action is 'update'
        if ($params == 'update') {
            $getTokenData = $this->is_authorized('superadmin');
            $usersData = json_decode(json_encode($getTokenData), true);
            $session_id = $usersData['data']['id'];
    
            $_POST = json_decode($this->input->raw_input_stream, true);
    
            // Set validation rules
            $this->form_validation->set_rules('id', 'ID', 'trim|required|integer|xss_clean');
            $this->form_validation->set_rules('remark', 'Remark', 'trim|required|xss_clean');
            $this->form_validation->set_rules('status', 'Status', 'trim|required|xss_clean');
    
            if ($this->form_validation->run() === false) {
                $array_error = array_map(function ($val) {
                    return str_replace(array("\r", "\n"), '', strip_tags($val));
                }, array_filter(explode(".", trim(strip_tags(validation_errors())))));
    
                $this->response([
                    'status' => false,
                    'message' => 'Error in form submission',
                    'errors' => $array_error
                ], REST_Controller::HTTP_BAD_REQUEST, '', 'error');
            } else {
                // Set the data for updating
                $id = $this->input->post('id', true);
                $data = [
                    'remark' => $this->input->post('remark', true),
                    'status' => $this->input->post('status', true),
                    'updatedBy' => $session_id,
                    'updated' => date('Y-m-d H:i:s')
                ];
    
                // Update the reported user data
                if ($this->reported_users_model->update($data, $id)) {
                    $final = [
                        'status' => true,
                        'data' => $this->reported_users_model->get($id),
                        'message' => 'Reported user updated successfully.'
                    ];
                    $this->response($final, REST_Controller::HTTP_OK);
                } else {
                    $this->response([
                        'status' => false,
                        'message' => 'There was a problem updating the reported user. Please try again.',
                        'errors' => [$this->db->error()]
                    ], REST_Controller::HTTP_BAD_REQUEST, '', 'error');
                }
            }
        }
    }
    

    public function reported_users_delete($id) {
        $this->is_authorized('superadmin');
        $response = $this->reported_users_model->delete($id);

        if ($response) {
            $this->response(['status' => true, 'message' => 'reported users deleted successfully.'], REST_Controller::HTTP_OK);
        } else {
            $this->response(['status' => false, 'message' => 'Not deleted'], REST_Controller::HTTP_BAD_REQUEST);
        }
    }
    // reported users end
}
