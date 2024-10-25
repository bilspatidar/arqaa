<?php
require APPPATH . '/libraries/REST_Controller.php';
use Restserver\Libraries\REST_Controller;

class Salary_head extends REST_Controller {

    public function __construct() {
        $this->cors_header();
        parent::__construct();
        $this->load->model('salary_head_model'); 
        $this->load->helper('security');
    }

    // Salary Head start
    public function salary_head_list_post() {
        $input_data = file_get_contents('php://input');
        $request_data = json_decode($input_data, true);
    
        $id = $this->input->get('id') ? $this->input->get('id') : 0;
    
        $page = isset($request_data['page']) ? $request_data['page'] : 1; // Default to page 1 if not provided
        $limit = isset($request_data['limit']) ? $request_data['limit'] : 10; // Default limit to 10 if not provided
        $filterData = isset($request_data['filterData']) ? $request_data['filterData'] : [];
    
        $getTokenData = $this->is_authorized('superadmin');
        $offset = ($page - 1) * $limit;
    
        $totalRecords =  $this->salary_head_model->get('yes', $id, $limit, $offset, $filterData);
        $data =  $this->salary_head_model->get('no', $id, $limit, $offset, $filterData);
    
        $totalPages = ceil($totalRecords / $limit);
    
        $response = [
            'status' => true,
            'data' => $data,
            'pagination' => [
                'page' => $page,
                'totalPages' => $totalPages,
                'totalRecords' => $totalRecords
            ],
            'message' => 'Salary head fetched successfully.'
        ];
        $this->response($response, REST_Controller::HTTP_OK); 
    }

    public function salary_head_details_get(){
        $id = $this->input->get('id') ? $this->input->get('id') : 0;
        $getTokenData = $this->is_authorized('superadmin');
        $data =  $this->salary_head_model->show($id);
        $response = [
            'status' => true,
            'data' => $data,
            'message' => 'Salary head fetched successfully.'
        ];
        $this->response($response, REST_Controller::HTTP_OK); 
    }

    public function salary_head_post($params='') {
        if($params=='add') {
            $getTokenData = $this->is_authorized('superadmin');
            $usersData = json_decode(json_encode($getTokenData), true);
            $session_id = $usersData['data']['id'];
            $_POST = json_decode($this->input->raw_input_stream, true);
            
            $this->form_validation->set_rules('head_name', 'Head Name', 'trim|required|xss_clean|alpha_numeric_spaces');
            
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
                $head_name = $this->input->post('head_name',TRUE);
                if (!empty($head_name)) {
                    $data['head_name'] = $head_name;
                }
                $data['types'] = $this->input->post('types',TRUE);
                $data['status'] = 'Active';
                $data['description'] = $this->input->post('description',TRUE);
                $data['added'] = date('Y-m-d H:i:s');
                $data['added_by'] = $session_id;
                
                if ($res = $this->salary_head_model->create($data)) {
                    $final = array();
                    $final['status'] = true;
                    $final['data'] = $this->salary_head_model->get($res);
                    $final['message'] = 'Salary head created successfully.';
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
        
            $this->form_validation->set_rules('head_name', 'Head Name', 'trim|required|xss_clean|alpha_numeric_spaces');
           
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
                $head_name = $this->input->post('head_name',TRUE);
                if (!empty($head_name)) {
                    $data['head_name'] = $head_name;
                }
                $data['types'] = $this->input->post('types',TRUE);
                $data['description'] = $this->input->post('description',TRUE);
                $data['status'] = $this->input->post('status',TRUE);
                $data['updated_by'] = $session_id;
                $data['updated'] = date('Y-m-d H:i:s');
                $id = $this->input->post('id');
                $res = $this->salary_head_model->update($data, $id);
        
                if ($res) {
                    $final = array();
                    $final['status'] = true;
                    $final['data'] = $this->salary_head_model->get($id);
                    $final['message'] = 'Salary head updated successfully.';
                    $this->response($final, REST_Controller::HTTP_OK);
                } else {
                    $this->response([
                        'status' => FALSE,
                        'message' => 'There was a problem updating Salary Head. Please try again',
                        'errors' => [$this->db->error()]
                    ], REST_Controller::HTTP_BAD_REQUEST, '', 'error');
                }
            }
        }
    }

    public function salary_head_delete($id) {
        $this->is_authorized('superadmin');
        $response = $this->salary_head_model->delete($id);

        if ($response) {
            $this->response(['status' => true, 'message' => 'Salary head deleted successfully.'], REST_Controller::HTTP_OK);
        } else {
            $this->response(['status' => false, 'message' => 'Not deleted'], REST_Controller::HTTP_BAD_REQUEST);
        }
    }
    // Salary Head end
}
