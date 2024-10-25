<?php
require APPPATH . '/libraries/REST_Controller.php';
use Restserver\Libraries\REST_Controller;

class Notification extends REST_Controller {

    public function __construct() {
        $this->cors_header();
        parent::__construct();
        $this->load->model('notification_model'); 
        $this->load->helper('security');
    }

    public function notification_list_post() {
        $input_data = file_get_contents('php://input');
        $request_data = json_decode($input_data, true);
    
        $user_id = $this->input->get('user_id') ? $this->input->get('user_id') : 0;
    
        $page = isset($request_data['page']) ? $request_data['page'] : 1; // Default to page 1 if not provided
        $limit = isset($request_data['limit']) ? $request_data['limit'] : 10; // Default limit to 10 if not provided
        $filterData = isset($request_data['filterData']) ? $request_data['filterData'] : [];
    
        $getTokenData = $this->is_authorized('superadmin');
        $offset = ($page - 1) * $limit;
    
        $totalRecords =  $this->notification_model->get('yes', $user_id, $limit, $offset, $filterData);
        $data =  $this->notification_model->get('no', $user_id, $limit, $offset, $filterData);
    
        $totalPages = ceil($totalRecords / $limit);
    
        $response = [
            'status' => true,
            'data' => $data,
            'pagination' => [
                'page' => $page,
                'totalPages' => $totalPages,
                'totalRecords' => $totalRecords
            ],
            'message' => 'Notifications fetched successfully.'
        ];
        $this->response($response, REST_Controller::HTTP_OK); 
    }

    public function notification_details_get(){
        $id = $this->input->get('id') ? $this->input->get('id') : 0;
        $getTokenData = $this->is_authorized('superadmin');
        $data =  $this->notification_model->show($id);
        $response = [
            'status' => true,
            'data' => $data,
            'message' => 'Notification fetched successfully.'
        ];
        $this->response($response, REST_Controller::HTTP_OK); 
    }

    public function notification_post($params='') {
        if($params=='add') {
            $getTokenData = $this->is_authorized('superadmin');
            $usersData = json_decode(json_encode($getTokenData), true);
            $session_id = $usersData['data']['id'];
            $_POST = json_decode($this->input->raw_input_stream, true);
            
            $this->form_validation->set_rules('title', 'Title', 'trim|required|xss_clean');
            $this->form_validation->set_rules('user_id', 'User ID', 'trim|required|numeric');
            $this->form_validation->set_rules('description', 'Description', 'trim|required|xss_clean');
            // Add more validation rules as needed
            
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
                $data['title'] = $this->input->post('title', TRUE);
                $data['user_id'] = $this->input->post('user_id', TRUE);
                $data['description'] = $this->input->post('description', TRUE);
                $data['added'] = date('Y-m-d H:i:s');
                $data['is_read'] = '0';
                $data['link'] = $this->input->post('link', TRUE);
                // Add more data fields as needed
                
                if ($res = $this->notification_model->create($data)) {
                    $final = array();
                    $final['status'] = true;
                    $final['data'] = $this->notification_model->get($res);
                    $final['message'] = 'Notification created successfully.';
                    $this->response($final, REST_Controller::HTTP_OK);
                } else {
                    $this->response([ 'status' => FALSE,
                        'message' =>'Error in submit form',
                        'errors' =>[$this->db->error()]], REST_Controller::HTTP_BAD_REQUEST,'','error');
                }
            }
        }
    
      if ($params == 'update') {
        $getTokenData = $this->is_authorized('superadmin');
        $usersData = json_decode(json_encode($getTokenData), true);
        $session_id = $usersData['data']['id'];
    
        $_POST = json_decode($this->input->raw_input_stream, true);
    
        // set validation rules
        $this->form_validation->set_rules('title', 'Title', 'trim|required|xss_clean');
        $this->form_validation->set_rules('user_id', 'User ID', 'trim|required|numeric');
        $this->form_validation->set_rules('description', 'Description', 'trim|required|xss_clean');
        // Add more validation rules as needed
    
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
            $id = $this->input->post('id');
            $data['title'] = $this->input->post('title', TRUE);
            $data['user_id'] = $this->input->post('user_id', TRUE);
            $data['description'] = $this->input->post('description', TRUE);
            $data['link'] = $this->input->post('link', TRUE);
            // Add more data fields as needed
            
            $res = $this->notification_model->update($data, $id);
    
            if ($res) {
                $final = array();
                $final['status'] = true;
                $final['data'] = $this->notification_model->get($id);
                $final['message'] = 'Notification updated successfully.';
                $this->response($final, REST_Controller::HTTP_OK);
            } else {
                $this->response([
                    'status' => FALSE,
                    'message' => 'There was a problem updating Notification. Please try again',
                    'errors' => [$this->db->error()]
                ], REST_Controller::HTTP_BAD_REQUEST, '', 'error');
            }
        }
      }
    
    }


    public function notification_delete($id) {
        $this->is_authorized('superadmin');
        $response = $this->notification_model->delete($id);

        if ($response) {
            $this->response(['status' => true, 'message' => 'Notification deleted successfully.'], REST_Controller::HTTP_OK);
        } else {
            $this->response(['status' => false, 'message' => 'Not deleted'], REST_Controller::HTTP_BAD_REQUEST);
        }
    }
}
