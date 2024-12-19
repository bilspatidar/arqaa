<?php
require APPPATH . '/libraries/REST_Controller.php';
use Restserver\Libraries\REST_Controller;

class Service_booking extends REST_Controller {
    
    /**
     * CONSTRUCTOR | LOAD MODEL
     *
     * @return Response
    */
    public function __construct() {
        $this->cors_header();
        parent::__construct();
        $this->load->model('service_booking_model');
        $this->load->helper('security');
    }

    // Service Booking List
    public function service_booking_list_post() {
        $input_data = file_get_contents('php://input');
        $request_data = json_decode($input_data, true);
    
        $id = $this->input->get('id') ? $this->input->get('id') : 0;
    
        $page = isset($request_data['page']) ? $request_data['page'] : 1; // Default to page 1 if not provided
        $limit = isset($request_data['limit']) ? $request_data['limit'] : 10; // Default limit to 10 if not provided
        $filterData = isset($request_data['filterData']) ? $request_data['filterData'] : [];
    
        $getTokenData = $this->is_authorized(array('superadmin','admin','company','freelancer'));
        $offset = ($page - 1) * $limit;
    
        $totalRecords =  $this->service_booking_model->get('yes', $id, $limit, $offset, $filterData);
        $data =  $this->service_booking_model->get('no', $id, $limit, $offset, $filterData);
    
        $totalPages = ceil($totalRecords / $limit);
    
        $response = [
            'status' => true,
            'data' => $data,
            'pagination' => [
                'page' => $page,
                'totalPages' => $totalPages,
                'totalRecords' => $totalRecords
            ],
            'message' => 'Service bookings fetched successfully.'
        ];
        $this->response($response, REST_Controller::HTTP_OK); 
    }
    
    // Service Booking Details
    public function service_booking_details_get() {
        $id = $this->input->get('id') ? $this->input->get('id') : 0;
        $getTokenData = $this->is_authorized(array('superadmin','admin','company','freelancer'));
        $data = $this->service_booking_model->show($id);
        
        $response = [
            'status' => true,
            'data' => $data,
            'message' => 'Service booking details fetched successfully.'
        ];
        $this->response($response, REST_Controller::HTTP_OK); 
    }

    // Add or Update Service Booking
    public function service_booking_post($params='') {
        if ($params == 'add') {
            $getTokenData = $this->is_authorized(array('superadmin','admin','company','freelancer'));
            $usersData = json_decode(json_encode($getTokenData), true);
            $session_id = $usersData['data']['id'];

            $_POST = json_decode($this->input->raw_input_stream, true);

            // Validation Rules
            $this->form_validation->set_rules('service_id', 'Service ID', 'trim|required|integer');
            $this->form_validation->set_rules('service_date', 'Service Date', 'trim|required');
            $this->form_validation->set_rules('service_time', 'Service Time', 'trim|required');
            $this->form_validation->set_rules('description', 'Description', 'trim');

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
                // Set Variables from Form
                $data['service_id'] = $this->input->post('service_id', TRUE);
                $data['service_date'] = $this->input->post('service_date', TRUE);
                $data['service_time'] = $this->input->post('service_time', TRUE);
                $data['description'] = $this->input->post('description', TRUE);
                $data['status'] = 'Active'; // Default status
                $data['added'] = date('Y-m-d H:i:s');
                $data['added_by'] = $session_id;

                // Create Service Booking
                if ($res = $this->service_booking_model->create($data)) {
                    $final = array();
                    $final['status'] = true;
                    $final['data'] = $this->service_booking_model->get($res);
                    $final['message'] = 'Service booking created successfully.';
                    $this->response($final, REST_Controller::HTTP_OK); 
                } else {
                    $this->response([
                        'status' => FALSE,
                        'message' => 'Error in submit form',
                        'errors' => [$this->db->error()]
                    ], REST_Controller::HTTP_BAD_REQUEST, '', 'error');
                }
            }
        }

        if ($params == 'update') {
            $getTokenData = $this->is_authorized(array('superadmin','admin','company','freelancer'));
            $usersData = json_decode(json_encode($getTokenData), true);
            $session_id = $usersData['data']['id'];

            $_POST = json_decode($this->input->raw_input_stream, true);
            $id = $this->input->post('id', TRUE);

            // Validation Rules
            $this->form_validation->set_rules('service_id', 'Service ID', 'trim|required|integer');
            $this->form_validation->set_rules('service_date', 'Service Date', 'trim|required');
            $this->form_validation->set_rules('service_time', 'Service Time', 'trim|required');
            $this->form_validation->set_rules('description', 'Description', 'trim');

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
                // Set Variables from Form
                $data['service_id'] = $this->input->post('service_id', TRUE);
                $data['service_date'] = $this->input->post('service_date', TRUE);
                $data['service_time'] = $this->input->post('service_time', TRUE);
                $data['description'] = $this->input->post('description', TRUE);
                $data['status'] = $this->input->post('status', TRUE); // Update Status
                $data['updated'] = date('Y-m-d H:i:s');
                $data['updated_by'] = $session_id;

                // Update Service Booking
                $res = $this->service_booking_model->update($data, $id);
        
                if ($res) {
                    $final = array();
                    $final['status'] = true;
                    $final['data'] = $this->service_booking_model->get($id);
                    $final['message'] = 'Service booking updated successfully.';
                    $this->response($final, REST_Controller::HTTP_OK); 
                } else {
                    $this->response([
                        'status' => FALSE,
                        'message' => 'There was a problem updating Service booking. Please try again',
                        'errors' => [$this->db->error()]
                    ], REST_Controller::HTTP_BAD_REQUEST, '', 'error');
                }
            }
        }
    }

    // Delete Service Booking
    public function service_booking_delete($id) {
        $this->is_authorized(array('superadmin','admin','company','freelancer'));
        $response = $this->service_booking_model->delete($id);

        if ($response) {
            $this->response(['status' => true, 'message' => 'Service booking deleted successfully.'], REST_Controller::HTTP_OK);
        } else {
            $this->response(['status' => false, 'message' => 'Not deleted'], REST_Controller::HTTP_BAD_REQUEST);
        }
    }
}
