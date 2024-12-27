<?php
   require APPPATH . '/libraries/REST_Controller.php';
   use Restserver\Libraries\REST_Controller;

class Country extends REST_Controller {
    
    /**
     * CONSTRUCTOR | LOAD MODEL
     *
     * @return Response
    */
    public function __construct() {
        $this->cors_header();
        parent::__construct();
        $this->load->model('country_model');
        $this->load->helper('security');
    }

    // country start
    public function country_list_post() {
        $input_data = file_get_contents('php://input');
        $request_data = json_decode($input_data, true);
    
        $id = $this->input->get('id') ? $this->input->get('id') : 0;
    
        $page = isset($request_data['page']) ? $request_data['page'] : 1; // Default to page 1 if not provided
        $limit = isset($request_data['limit']) ? $request_data['limit'] : 10; // Default limit to 10 if not provided
        $filterData = isset($request_data['filterData']) ? $request_data['filterData'] : [];
    
        //$getTokenData = $this->is_authorized('superadmin');
        $offset = ($page - 1) * $limit;
    
        $totalRecords =  $this->country_model->get('yes', $id, $limit, $offset, $filterData);
        $data =  $this->country_model->get('no', $id, $limit, $offset, $filterData);
    
        $totalPages = ceil($totalRecords / $limit);
    
        $response = [
            'status' => true,
            'data' => $data,
            'pagination' => [
                'page' => $page,
                'totalPages' => $totalPages,
                'totalRecords' => $totalRecords
            ],
            'message' => 'Country fetched successfully.'
        ];
        $this->response($response, REST_Controller::HTTP_OK); 
    }
    
    public function country_details_get(){
        $id = $this->input->get('id') ? $this->input->get('id') : 0;
        $getTokenData = $this->is_authorized(array('superadmin','admin','company','freelancer'));
        $data =  $this->country_model->show($id);
        $response = [
            'status' => true,
            'data' => $data,
            'message' => 'Country fetched successfully.'
        ];
        $this->response($response, REST_Controller::HTTP_OK); 
    }
    public function country_post($params='') {
        if($params=='add') {
            $getTokenData = $this->is_authorized(array('superadmin','admin','company','freelancer'));
            $usersData = json_decode(json_encode($getTokenData), true);
            $session_id = $usersData['data']['users_id'];

            $_POST = json_decode($this->input->raw_input_stream, true);

            // set validation rules
            $this->form_validation->set_rules('name', 'Country Name', 'trim|required|xss_clean|alpha_numeric_spaces|is_unique[countries.name]');
            $this->form_validation->set_rules('shortname', 'Short Name', 'trim|required|xss_clean|alpha_numeric_spaces');
            
           

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

                $shortname = $this->input->post('shortname',TRUE);
                if (!empty($shortname)) {
                    $data['shortname'] = $shortname;
                }

                $data['status'] = 'Active';
                $data['added'] = date('Y-m-d H:i:s');
                $data['addedBy'] = $session_id;

                if ($res = $this->country_model->create($data)) {
                    // country creation ok
                    $final = array();
                    $final['status'] = true;
                    $final['data'] = $this->country_model->get($res);
                    $final['message'] = 'Country created successfully.';
                    $this->response($final, REST_Controller::HTTP_OK); 
                } else {
                    // country creation failed, this should never happen
                    $this->response([ 'status' => FALSE,
                        'message' =>'Error in submit form',
                        'errors' =>[$this->db->error()]], REST_Controller::HTTP_BAD_REQUEST,'','error');
                }
            }
        }

        if ($params == 'update') {
            $getTokenData = $this->is_authorized(array('superadmin','admin','company','freelancer'));
            $usersData = json_decode(json_encode($getTokenData), true);
            $session_id = $usersData['data']['users_id'];
        
            $_POST = json_decode($this->input->raw_input_stream, true);
            $id = $this->input->post('id');
            // set validation rules
            $this->form_validation->set_rules('name', 'Country Name', 'trim|required|xss_clean|alpha_numeric_spaces|edit_unique[countries.name.id.'.$id.']');
            $this->form_validation->set_rules('shortname', 'Short Name', 'trim|required|xss_clean|alpha_numeric_spaces');
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

                $shortname = $this->input->post('shortname',TRUE);
                if (!empty($shortname)) {
                    $data['shortname'] = $shortname;
                }
        
                $status = $this->input->post('status',TRUE);
                if (!empty($status)) {
                    $data['status'] = $status;
                }
        
                $data['updatedBy'] = $session_id;
                $data['updated'] = date('Y-m-d H:i:s');
                $res = $this->country_model->update($data, $id);
        
                if ($res) {
                    // country update ok
                    $final = array();
                    $final['status'] = true;
                    $final['data'] = $this->country_model->get($id);
                    $final['message'] = 'Country updated successfully.';
                    $this->response($final, REST_Controller::HTTP_OK);
                } else {
                    // country update failed, this should never happen
                    $this->response([
                        'status' => FALSE,
                        'message' => 'There was a problem updating country. Please try again',
                        'errors' => [$this->db->error()]
                    ], REST_Controller::HTTP_BAD_REQUEST, '', 'error');
                }
            }
        }
        
    }
    
    public function country_tax_post($params='') {
         if ($params == 'update') {
            $getTokenData = $this->is_authorized(array('superadmin','admin','company','freelancer'));
            $usersData = json_decode(json_encode($getTokenData), true);
            $session_id = $usersData['data']['users_id'];
        
            $_POST = json_decode($this->input->raw_input_stream, true);
            $id = $this->input->post('category_id');
            // set validation rules
            $this->form_validation->set_rules('category_id', 'Country Name', 'trim|required|xss_clean|alpha_numeric_spaces');
            $this->form_validation->set_rules('tax', 'Tax', 'trim|required|xss_clean');

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
                $tax = $this->input->post('tax',TRUE);
                if (!empty($tax)) {
                    $data['tax'] = $tax;
                }
                

               
        
                $data['updatedBy'] = $session_id;
                $data['updated'] = date('Y-m-d H:i:s');
                $res = $this->country_model->update($data, $id);
        
                if ($res) {
                    // country update ok
                    $final = array();
                    $final['status'] = true;
                    $final['data'] = $this->country_model->get($id);
                    $final['message'] = 'Country tax updated successfully.';
                    $this->response($final, REST_Controller::HTTP_OK);
                } else {
                    // country update failed, this should never happen
                    $this->response([
                        'status' => FALSE,
                        'message' => 'There was a problem updating country tax. Please try again',
                        'errors' => [$this->db->error()]
                    ], REST_Controller::HTTP_BAD_REQUEST, '', 'error');
                }
            }
        }
        
    }
   
    
     public function country_tax_list_post() {
        $input_data = file_get_contents('php://input');
        $request_data = json_decode($input_data, true);
    
        $id = $this->input->get('id') ? $this->input->get('id') : 0;
    
        $page = isset($request_data['page']) ? $request_data['page'] : 1; // Default to page 1 if not provided
        $limit = isset($request_data['limit']) ? $request_data['limit'] : 10; // Default limit to 10 if not provided
        $filterData = isset($request_data['filterData']) ? $request_data['filterData'] : [];
    
        //$getTokenData = $this->is_authorized('superadmin');
        $offset = ($page - 1) * $limit;
    
        $totalRecords =  $this->country_model->get_country_tax('yes', $id, $limit, $offset, $filterData);
        $data =  $this->country_model->get_country_tax('no', $id, $limit, $offset, $filterData);
    
        $totalPages = ceil($totalRecords / $limit);
    
        $response = [
            'status' => true,
            'data' => $data,
            'pagination' => [
                'page' => $page,
                'totalPages' => $totalPages,
                'totalRecords' => $totalRecords
            ],
            'message' => 'Country fetched successfully.'
        ];
        $this->response($response, REST_Controller::HTTP_OK); 
    }
    
    public function country_delete($id) {
        $this->is_authorized(array('superadmin','admin','company','freelancer'));
        $response = $this->country_model->delete($id);

        if ($response) {
            $this->response(['status' => true, 'message' => 'Country deleted successfully.'], REST_Controller::HTTP_OK);
        } else {
            $this->response(['status' => false, 'message' => 'Not deleted'], REST_Controller::HTTP_BAD_REQUEST);
        }
    }
    // country end
}
