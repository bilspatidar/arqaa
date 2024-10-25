<?php
   require APPPATH . '/libraries/REST_Controller.php';
   use Restserver\Libraries\REST_Controller;

class State extends REST_Controller {
    
    /**
     * CONSTRUCTOR | LOAD MODEL
     *
     * @return Response
    */
    public function __construct() {
        $this->cors_header();
        parent::__construct();
        $this->load->model('state_model');
        $this->load->helper('security');
    }

    // state start
	public function parent_state_get($id='') {
        $getTokenData = $this->is_authorized('superadmin');
        $final = array();
        $final['status'] = true;
        $final['data'] = $this->state_model->parent_state($id);
        $final['message'] = 'Country parents state fetched successfully.';
        $this->response($final, REST_Controller::HTTP_OK); 
    }

    public function state_list_post() {
        $input_data = file_get_contents('php://input');
        $request_data = json_decode($input_data, true);
    
        $id = $this->input->get('id') ? $this->input->get('id') : 0;
    
        $page = isset($request_data['page']) ? $request_data['page'] : 1; // Default to page 1 if not provided
        $limit = isset($request_data['limit']) ? $request_data['limit'] : 10; // Default limit to 10 if not provided
        $filterData = isset($request_data['filterData']) ? $request_data['filterData'] : [];
    
        $getTokenData = $this->is_authorized('superadmin');
        $offset = ($page - 1) * $limit;
    
        $totalRecords =  $this->state_model->get('yes', $id, $limit, $offset, $filterData);
        $data =  $this->state_model->get('no', $id, $limit, $offset, $filterData);
    
        $totalPages = ceil($totalRecords / $limit);
    
        $response = [
            'status' => true,
            'data' => $data,
            'pagination' => [
                'page' => $page,
                'totalPages' => $totalPages,
                'totalRecords' => $totalRecords
            ],
            'message' => 'State fetched successfully.'
        ];
        $this->response($response, REST_Controller::HTTP_OK); 
    }
    
    public function state_details_get(){
        $id = $this->input->get('id') ? $this->input->get('id') : 0;
        $getTokenData = $this->is_authorized('superadmin');
        $data =  $this->state_model->show($id);
        $response = [
            'status' => true,
            'data' => $data,
            'message' => 'State fetched successfully.'
        ];
        $this->response($response, REST_Controller::HTTP_OK); 
    }

    public function state_post($params='') {
        if($params=='add') {
            $getTokenData = $this->is_authorized('superadmin');
            $usersData = json_decode(json_encode($getTokenData), true);
            $session_id = $usersData['data']['users_id'];

            $_POST = json_decode($this->input->raw_input_stream, true);

            // set validation rules
            $this->form_validation->set_rules('name', 'State Name', 'trim|required|xss_clean|alpha_numeric_spaces|is_unique[states.name]');
            $this->form_validation->set_rules('country_id', 'Country', 'trim|required|xss_clean|numeric');

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
                $name = $this->input->post('name',TRUE);
                if (!empty($name)) {
                    $data['name'] = $name;
                }

                $country_id = $this->input->post('country_id',TRUE);
                if (!empty($country_id)) {
                    $data['country_id'] = $country_id;
                }

                $data['status'] = 'Active';
                $data['added'] = date('Y-m-d H:i:s');
                $data['addedBy'] = $session_id;

                if ($res = $this->state_model->create($data)) {
                    // state creation ok
                    $final = array();
                    $final['status'] = true;
                    $final['data'] = $this->state_model->get($res);
                    $final['message'] = 'State created successfully.';
                    $this->response($final, REST_Controller::HTTP_OK); 
                } else {
                    // state creation failed, this should never happen
                    $this->response([ 'status' => FALSE,
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
            $id = $this->input->post('id');
            // set validation rules
            $this->form_validation->set_rules('name', 'State Name', 'trim|required|xss_clean|alpha_numeric_spaces|edit_unique[states.name.id.'.$id.']');
            $this->form_validation->set_rules('country_id', 'Country', 'trim|required|xss_clean|numeric');
            $this->form_validation->set_rules('status', 'Status', 'trim|xss_clean|alpha');
        
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
                // set variables from the form
                $name = $this->input->post('name',TRUE);
                if (!empty($name)) {
                    $data['name'] = $name;
                }

                $country_id = $this->input->post('country_id',TRUE);
                if (!empty($country_id)) {
                    $data['country_id'] = $country_id;
                }
        
                $status = $this->input->post('status',TRUE);
                if (!empty($status)) {
                    $data['status'] = $status;
                }
        
                $data['updatedBy'] = $session_id;
                $data['updated'] = date('Y-m-d H:i:s');
                $res = $this->state_model->update($data, $id);
        
                if ($res) {
                    // state update ok
                    $final = array();
                    $final['status'] = true;
                    $final['data'] = $this->state_model->get($id);
                    $final['message'] = 'State updated successfully.';
                    $this->response($final, REST_Controller::HTTP_OK);
                } else {
                    // state update failed, this should never happen
                    $this->response([
                        'status' => FALSE,
                        'message' => 'There was a problem updating state. Please try again',
                        'errors' => [$this->db->error()]
                    ], REST_Controller::HTTP_BAD_REQUEST, '', 'error');
                }
            }
        }
        
    }

    public function state_delete($id) {
        $this->is_authorized('superadmin');
        $response = $this->state_model->delete($id);

        if ($response) {
            $this->response(['status' => true, 'message' => 'State deleted successfully.'], REST_Controller::HTTP_OK);
        } else {
            $this->response(['status' => false, 'message' => 'Not deleted'], REST_Controller::HTTP_BAD_REQUEST);
        }
    }
    // State end
}
