<?php
require APPPATH . '/libraries/REST_Controller.php';
use Restserver\Libraries\REST_Controller;

class Salary_level extends REST_Controller {

    public function __construct() {
        $this->cors_header();
        parent::__construct();
        $this->load->model('salary_level_model'); 
        $this->load->helper('security');
    }

    public function salary_level_list_post() {
        $input_data = file_get_contents('php://input');
        $request_data = json_decode($input_data, true);
    
        $id = $this->input->get('id') ? $this->input->get('id') : 0;
    
        $page = isset($request_data['page']) ? $request_data['page'] : 1; // Default to page 1 if not provided
        $limit = isset($request_data['limit']) ? $request_data['limit'] : 10; // Default limit to 10 if not provided
        $filterData = isset($request_data['filterData']) ? $request_data['filterData'] : [];
    
        $getTokenData = $this->is_authorized('superadmin');
        $offset = ($page - 1) * $limit;
    
        $totalRecords =  $this->salary_level_model->get('yes', $id, $limit, $offset, $filterData);
        $data =  $this->salary_level_model->get('no', $id, $limit, $offset, $filterData);
    
        $totalPages = ceil($totalRecords / $limit);
    
        $response = [
            'status' => true,
            'data' => $data,
            'pagination' => [
                'page' => $page,
                'totalPages' => $totalPages,
                'totalRecords' => $totalRecords
            ],
            'message' => 'Salary level fetched successfully.'
        ];
        $this->response($response, REST_Controller::HTTP_OK); 
    }

    public function salary_level_details_get(){
        $id = $this->input->get('id') ? $this->input->get('id') : 0;
        $getTokenData = $this->is_authorized('superadmin');
        $data =  $this->salary_level_model->show($id);
        $response = [
            'status' => true,
            'data' => $data,
            'message' => 'Salary level fetched successfully.'
        ];
        $this->response($response, REST_Controller::HTTP_OK); 
    }

    public function salary_level_post($params='') {
        if($params=='add') {
            $getTokenData = $this->is_authorized('superadmin');
            $usersData = json_decode(json_encode($getTokenData), true);
            $session_id = $usersData['data']['id'];
            $_POST = json_decode($this->input->raw_input_stream, true);
            
            $this->form_validation->set_rules('name', 'Name', 'trim|required|xss_clean|alpha_numeric_spaces');
            $this->form_validation->set_rules('salary_head_id', 'Salary Head ID', 'trim|required|xss_clean|numeric');
            $this->form_validation->set_rules('salary_head_value', 'Salary Head Value', 'trim|required|xss_clean|numeric');
            
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
                $name = $this->input->post('name',TRUE);
                $salary_head_id = $this->input->post('salary_head_id',TRUE);
                $salary_head_value = $this->input->post('salary_head_value',TRUE);

                $data['name'] = $name;
                $data['salary_head_id'] = $salary_head_id;
                $data['salary_head_value'] = $salary_head_value;
                $data['status'] = 'Active';

                if ($res = $this->salary_level_model->create($data)) {
                    $final = array();
                    $final['status'] = true;
                    $final['data'] = $this->salary_level_model->get($res);
                    $final['message'] = 'Salary level created successfully.';
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
        
            $this->form_validation->set_rules('name', 'Name', 'trim|required|xss_clean|alpha_numeric_spaces');
            $this->form_validation->set_rules('salary_head_id', 'Salary Head ID', 'trim|required|xss_clean|numeric');
            $this->form_validation->set_rules('salary_head_value', 'Salary Head Value', 'trim|required|xss_clean|numeric');
           
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
                $name = $this->input->post('name',TRUE);
                $salary_head_id = $this->input->post('salary_head_id',TRUE);
                $salary_head_value = $this->input->post('salary_head_value',TRUE);

                $data['name'] = $name;
                $data['salary_head_id'] = $salary_head_id;
                $data['salary_head_value'] = $salary_head_value;
                $data['status'] = $this->input->post('status',TRUE);

                $id = $this->input->post('id');
                $res = $this->salary_level_model->update($data, $id);
        
                if ($res) {
                    $final = array();
                    $final['status'] = true;
                    $final['data'] = $this->salary_level_model->get($id);
                    $final['message'] = 'Salary level updated successfully.';
                    $this->response($final, REST_Controller::HTTP_OK);
                } else {
                    $this->response([
                        'status' => FALSE,
                        'message' => 'There was a problem updating Salary Level. Please try again',
                        'errors' => [$this->db->error()]
                    ], REST_Controller::HTTP_BAD_REQUEST, '', 'error');
                }
            }
        }
    }

    public function salary_level_delete($id) {
        $this->is_authorized('superadmin');
        $response = $this->salary_level_model->delete($id);

        if ($response) {
            $this->response(['status' => true, 'message' => 'Salary level deleted successfully.'], REST_Controller::HTTP_OK);
        } else {
            $this->response(['status' => false, 'message' => 'Not deleted'], REST_Controller::HTTP_BAD_REQUEST);
        }
    }
}
