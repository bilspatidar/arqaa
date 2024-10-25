<?php
   require APPPATH . '/libraries/REST_Controller.php';
   use Restserver\Libraries\REST_Controller;

class Banners extends REST_Controller {
    
    /**
     * CONSTRUCTOR | LOAD MODEL
     *
     * @return Response
    */
    public function __construct() {
        $this->cors_header();
        parent::__construct();
        $this->load->model('banners_model');
        $this->load->helper('security');
    }

    
    public function banners_list_post() {
        $input_data = file_get_contents('php://input');
        $request_data = json_decode($input_data, true);
    
        $id = $this->input->get('id') ? $this->input->get('id') : 0;
    
        $page = isset($request_data['page']) ? $request_data['page'] : 1; // Default to page 1 if not provided
        $limit = isset($request_data['limit']) ? $request_data['limit'] : 10; // Default limit to 10 if not provided
        $filterData = isset($request_data['filterData']) ? $request_data['filterData'] : [];
    
        $getTokenData = $this->is_authorized('superadmin');
        $offset = ($page - 1) * $limit;
    
        $totalRecords =  $this->banners_model->get('yes', $id, $limit, $offset, $filterData);
        $data =  $this->banners_model->get('no', $id, $limit, $offset, $filterData);
    
        $totalPages = ceil($totalRecords / $limit);
    
        $response = [
            'status' => true,
            'data' => $data,
            'pagination' => [
                'page' => $page,
                'totalPages' => $totalPages,
                'totalRecords' => $totalRecords
            ],
            'message' => 'Data fetched successfully.'
        ];
        $this->response($response, REST_Controller::HTTP_OK); 
    }
    
    public function banners_details_get(){
        $id = $this->input->get('id') ? $this->input->get('id') : 0;
        $getTokenData = $this->is_authorized('superadmin');
        $data =  $this->banners_model->show($id);
        $response = [
            'status' => true,
            'data' => $data,
            'message' => 'Data fetched successfully.'
        ];
        $this->response($response, REST_Controller::HTTP_OK); 
    }


    public function banners_post($params='') {
        if($params=='add') {
            $getTokenData = $this->is_authorized('superadmin');
            $usersData = json_decode(json_encode($getTokenData), true);
            $session_id = $usersData['data']['id'];

            $_POST = json_decode($this->input->raw_input_stream, true);

            // set validation rules
            $this->form_validation->set_rules('concept', 'concept', 'trim|required');
            $this->form_validation->set_rules('price', 'price', 'trim|required');
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
                $data['concept'] = $this->input->post('concept',TRUE);
                $data['price'] = $this->input->post('price',TRUE);
                $data['currency'] = $this->input->post('currency',TRUE);
				$data['status'] = 'Active';
                $data['added'] = date('Y-m-d H:i:s');
                $data['addedBy'] = $session_id;

                if ($res = $this->banners_model->create($data)) {
                    // creation ok
                    $final = array();
                    $final['status'] = true;
                    $final['data'] = $this->banners_model->get($res);
                    $final['message'] = 'Data created successfully.';
                    $this->response($final, REST_Controller::HTTP_OK); 
                } else {
                    // creation failed, this should never happen
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
            $this->form_validation->set_rules('concept', 'concept', 'trim|required|xss_clean|alpha_numeric_spaces');
        
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
				$id = $this->input->post('id',TRUE);
                $data['concept'] = $this->input->post('concept',TRUE);
                $data['price'] = $this->input->post('price',TRUE);
                $data['currency'] = $this->input->post('currency',TRUE);
				$data['status'] = $this->input->post('status',TRUE);
                $res = $this->banners_model->update($data, $id);
        
                if ($res) {
                    // update ok
                    $final = array();
                    $final['status'] = true;
                    $final['data'] = $this->banners_model->get($id);
                    $final['message'] = 'Data updated successfully.';
                    $this->response($final, REST_Controller::HTTP_OK);
                } else {
                    // update failed, this should never happen
                    $this->response([
                        'status' => FALSE,
                        'message' => 'There was a problem updating Data. Please try again',
                        'errors' => [$this->db->error()]
                    ], REST_Controller::HTTP_BAD_REQUEST, '', 'error');
                }
            }
        }
        
    }

    public function banners_delete($id) {
        $this->is_authorized('superadmin');
        $response = $this->banners_model->delete($id);

        if ($response) {
            $this->response(['status' => true, 'message' => 'Data deleted successfully.'], REST_Controller::HTTP_OK);
        } else {
            $this->response(['status' => false, 'message' => 'Not deleted'], REST_Controller::HTTP_BAD_REQUEST);
        }
    }
    // Additional Services end
}
